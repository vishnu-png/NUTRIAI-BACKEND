<?php
include 'config.php';

header('Content-Type: application/json');

$user_id = $_GET['user_id'] ?? '';

if (empty($user_id)) {
    echo json_encode(["error" => "User ID Missing"]);
    exit;
}

// Calculate last 7 days totals
$start_date = date("Y-m-d", strtotime("-7 days"));
$end_date = date("Y-m-d");

$query = "
    SELECT 
        IFNULL(SUM(calories),0) AS total_calories,
        IFNULL(SUM(protein),0) AS total_protein,
        IFNULL(SUM(iron),0) AS total_iron,
        IFNULL(SUM(calcium),0) AS total_calcium
    FROM meals
    WHERE user_id='$user_id' AND date BETWEEN '$start_date' AND '$end_date'
";

$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

// Weekly recommended values (can be adjusted per user later)
$recommended = [
    "calories" => 14000,   // 2000/day * 7
    "protein"  => 350,     // 50/day * 7
    "iron"     => 105,     // 15/day * 7
    "calcium"  => 7000     // 1000/day * 7
];

// Calculate deficit amounts (how much more needed this week)
$deficit = [];
foreach ($recommended as $k => $v) {
    $key = "total_" . $k;
    $have = isset($data[$key]) ? floatval($data[$key]) : 0;
    $need = max(0, $v - $have);
    $deficit[$k] = $need;
}

// Determine severity
$def_status = [];
foreach ($recommended as $k => $v) {
    $have = isset($data["total_".$k]) ? floatval($data["total_".$k]) : 0;
    if ($have < $v * 0.7) {
        $def_status[$k] = "High Deficiency Risk";
    } elseif ($have < $v) {
        $def_status[$k] = "Slight Deficiency";
    } else {
        $def_status[$k] = "Healthy Level";
    }
}

// Helper: fetch top foods by nutrient
function topFoodsByNutrient($conn, $nutrient_col, $limit = 6) {
    $nutrient_col_safe = preg_replace('/[^a-zA-Z0-9_]/', '', $nutrient_col);
    $sql = "SELECT id, food_name, category, $nutrient_col_safe AS value
            FROM foods
            WHERE $nutrient_col_safe > 0
            ORDER BY $nutrient_col_safe DESC
            LIMIT $limit";
    $res = mysqli_query($conn, $sql);
    $list = [];
    while ($r = mysqli_fetch_assoc($res)) {
        // cast numeric types
        $r['value'] = $r['value'] + 0;
        $list[] = $r;
    }
    return $list;
}

// Build recommendations only for nutrients that need them
$recommendations = [];

// Calories: recommend calorie-dense foods if deficit
if ($deficit['calories'] > 0) {
    $recommendations['calories'] = [
        "needed_amount" => $deficit['calories'],
        "suggestions" => topFoodsByNutrient($conn, 'calories', 8)
    ];
}

// Protein
if ($deficit['protein'] > 0) {
    $recommendations['protein'] = [
        "needed_amount" => $deficit['protein'],
        "suggestions" => topFoodsByNutrient($conn, 'protein', 8)
    ];
}

// Iron
if ($deficit['iron'] > 0) {
    $recommendations['iron'] = [
        "needed_amount" => $deficit['iron'],
        "suggestions" => topFoodsByNutrient($conn, 'iron', 8)
    ];
}

// Calcium
if ($deficit['calcium'] > 0) {
    $recommendations['calcium'] = [
        "needed_amount" => $deficit['calcium'],
        "suggestions" => topFoodsByNutrient($conn, 'calcium', 8)
    ];
}

// If no deficits, give general balanced suggestions (top protein + greens + calcium)
if (empty($recommendations)) {
    $recommendations['message'] = "No deficiencies detected for last 7 days. Maintain a balanced diet.";
    $recommendations['balanced_suggestions'] = [
        "protein_sources" => topFoodsByNutrient($conn, 'protein', 6),
        "iron_sources" => topFoodsByNutrient($conn, 'iron', 6),
        "calcium_sources" => topFoodsByNutrient($conn, 'calcium', 6)
    ];
}

// Final response
$response = [
    "weekly_intake" => $data,
    "recommended_weekly" => $recommended,
    "deficiency_status" => $def_status,
    "deficit_amounts" => $deficit,
    "food_recommendations" => $recommendations,
    "note" => "Recommendations are based on weekly totals and food nutrient columns in the foods table."
];

echo json_encode($response, JSON_PRETTY_PRINT);
?>
