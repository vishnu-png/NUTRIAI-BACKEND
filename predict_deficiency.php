<?php
include 'config.php';

$user_id = $_GET['user_id'] ?? '';

if(empty($user_id)){
    echo json_encode(["error" => "User ID Missing"]);
    exit;
}

$start_date = date("Y-m-d", strtotime("-7 days"));
$end_date = date("Y-m-d");

$query = "
    SELECT 
        SUM(calories) AS total_calories,
        SUM(protein) AS total_protein,
        SUM(iron) AS total_iron,
        SUM(calcium) AS total_calcium
    FROM meals
    WHERE user_id='$user_id' AND date BETWEEN '$start_date' AND '$end_date'
";

$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

// Weekly recommended values (approx)
$recommended = [
    "calories" => 14000,   // 2000 per day
    "protein"  => 350,     // 50 per day
    "iron"     => 105,     // 15 per day
    "calcium"  => 7000     // 1000 per day
];

$deficiency = [];

foreach ($recommended as $nutrient => $value) {
    if ($data["total_".$nutrient] < $value * 0.8) {
        $deficiency[$nutrient] = "High Deficiency Risk";
    } elseif ($data["total_".$nutrient] < $value) {
        $deficiency[$nutrient] = "Slight Deficiency";
    } else {
        $deficiency[$nutrient] = "Healthy Level";
    }
}

$response = [
    "weekly_intake" => $data,
    "recommended_weekly" => $recommended,
    "deficiency_status" => $deficiency
];

echo json_encode($response, JSON_PRETTY_PRINT);
?>
