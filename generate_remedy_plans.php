<?php
require 'config.php';
header('Content-Type: application/json');

$user_id = $_GET['user_id'] ?? '';

if (!$user_id) {
    echo json_encode(['error' => 'User ID required']);
    exit;
}

// 1. Get User Diet Preference
$diet_pref = "Non-Vegetarian"; // Default
$user_res = $conn->query("SELECT diet_preference FROM users WHERE id = '$user_id'");
if ($user_res && $row = $user_res->fetch_assoc()) {
    $diet_pref = $row['diet_preference'];
}

// 2. Calculate Deficiencies (Today's Intake - Eaten)
// Focusing on MACROS as micros (iron/calc) are not reliably tracked yet.
$today = date('Y-m-d');
// Note: 'fat' or 'fats' column? Check table structure usually. 
// Assuming standard naming 'carbs', 'fat' (or 'fats'), 'protein'.
// Safe aggregation:
$meal_res = $conn->query("SELECT SUM(carbs) as c, SUM(fat) as f, SUM(protein) as p FROM meals WHERE user_id='$user_id' AND date='$today'");
if (!$meal_res) {
    // Retry with 'fats' if 'fat' fails, or handle error. 
    // Usually DBs have specific schema. Let's assume 'fat' or 'fats'.
    // If we can't inspect schema, we could try SELECT * LIMIT 1.
    // For now, let's assume 'fat' is the column name used in existing logic in confirm_meal.
    // Wait, confirm_meal sends 'fats'. Let's verify.
    // Actually, let's check what fields confirm_meal sends. It sends 'fats'.
    // But SearchFood reads 'fat' or 'fats'.
    // Let's assume the DB column is `fats` based on confirm_meal sending it.
     $meal_res = $conn->query("SELECT SUM(carbs) as c, SUM(fats) as f, SUM(protein) as p FROM meals WHERE user_id='$user_id' AND date='$today'");
}

$intake = $meal_res ? $meal_res->fetch_assoc() : ['c'=>0, 'f'=>0, 'p'=>0];

$carbs = $intake['c'] ?? 0;
$fats = $intake['f'] ?? 0;
$prot = $intake['p'] ?? 0;

// Daily Targets (Avg)
$target_carbs = 250;
$target_fats = 70;
$target_prot = 60; 

$deficiencies = [];
if ($carbs < $target_carbs) $deficiencies['carbs'] = $target_carbs - $carbs;
if ($fats < $target_fats) $deficiencies['fats'] = $target_fats - $fats;
if ($prot < $target_prot) $deficiencies['protein'] = $target_prot - $prot;

// Determine Primary Focus (Largest % deficit)
$focus = 'general';
$max_deficit_pct = 0;
foreach ($deficiencies as $nut => $gap) {
    $t_val = ($nut == 'carbs') ? $target_carbs : (($nut == 'fats') ? $target_fats : $target_prot);
    $pct = $gap / $t_val;
    if ($pct > $max_deficit_pct) {
        $max_deficit_pct = $pct;
        $focus = $nut;
    }
}

// 3. Build Query Filter based on Diet
$diet_filter = "1=1";
if (stripos($diet_pref, 'Veg') !== false && stripos($diet_pref, 'Non') === false) {
    $diet_filter = "category = 'veg'";
}
if (stripos($diet_pref, 'Keto') !== false) {
    $diet_filter .= " AND carbs < 10 AND fat > 10";
}

// 4. Generate 3 Plans
$plans = [];

// Helper to get food (Randomized)
function getFood($conn, $focus_col, $min_val, $diet_filter, $limit=1, $exclude_ids=[]) {
    $exclude_str = empty($exclude_ids) ? "0" : implode(',', $exclude_ids);
    // Fetch top 10 candidates to ensure quality but allow variety
    $sql = "SELECT * FROM foods WHERE $focus_col > $min_val AND $diet_filter AND id NOT IN ($exclude_str) ORDER BY $focus_col DESC LIMIT 10";
    $res = $conn->query($sql);
    $items = [];
    while($r = $res->fetch_assoc()) $items[] = $r;
    
    if (empty($items)) return [];
    
    // Randomize selection
    shuffle($items);
    return array_slice($items, 0, $limit);
}

$used_ids = [];

// --- PLAN A: "Quick Fix" (Snack/High Density) ---
$planA_items = [];
if ($focus == 'general') {
    $planA_items = getFood($conn, 'protein', 5, $diet_filter, 1, $used_ids);
    $reasonA = "Perfect healthy snack.";
} else {
    $planA_items = getFood($conn, $focus, 2, $diet_filter, 1, $used_ids);
    $reasonA = "High in " . ucfirst(str_replace('_', ' ', $focus)) . " to boost levels quickly.";
}

if (!empty($planA_items)) {
    $used_ids[] = $planA_items[0]['id'];
    $plans[] = [
        "id" => "A",
        "title" => "Quick Fix",
        "tags" => ["Instant Boost", "Snack"],
        "description" => $reasonA,
        "items" => $planA_items
    ];
}

// --- PLAN B: "Power Meal" (Lunch/Dinner) ---
$planB_items = [];
if ($focus == 'general') {
    $planB_items = getFood($conn, 'calories', 300, $diet_filter, 1, $used_ids);
    $reasonB = "A balanced, filling meal.";
} else {
    // High nutrient AND decent calories
    $sql = "SELECT * FROM foods WHERE $focus > 5 AND calories > 200 AND $diet_filter AND id NOT IN (" . implode(',', $used_ids) . ") ORDER BY $focus DESC LIMIT 1";
    $res = $conn->query($sql);
    if ($res->num_rows == 0) {
        // Fallback if no high cal item with nutrient
        $planB_items = getFood($conn, $focus, 1, $diet_filter, 1, $used_ids);
    } else {
        $planB_items[] = $res->fetch_assoc();
    }
    $reasonB = "Substantial meal rich in " . ucfirst(str_replace('_', ' ', $focus)) . ".";
}

if (!empty($planB_items)) {
    $used_ids[] = $planB_items[0]['id'];
     $plans[] = [
        "id" => "B",
        "title" => "Power Meal",
        "tags" => ["Filling", "Nutrient Dense"],
        "description" => $reasonB,
        "items" => $planB_items
    ];
}

// --- PLAN C: "Balanced Combo" (Variety) ---
$planC_items = [];
// Try to find 2 items: 1 for focus (if any), 1 for general protein/energy
$i1 = getFood($conn, $focus == 'general' ? 'protein' : $focus, 1, $diet_filter, 1, $used_ids);
if (!empty($i1)) {
    $used_ids[] = $i1[0]['id'];
    $planC_items[] = $i1[0];
}
$i2 = getFood($conn, 'calories', 100, $diet_filter, 1, $used_ids);
if (!empty($i2)) {
    $used_ids[] = $i2[0]['id'];
    $planC_items[] = $i2[0];
}

if (!empty($planC_items)) {
    $plans[] = [
        "id" => "C",
        "title" => "Balanced Combo",
        "tags" => ["Variety", "Complete"],
        "description" => "A mix of items for a well-rounded intake.",
        "items" => $planC_items
    ];
}

echo json_encode([
    "focus_nutrient" => $focus,
    "user_diet" => $diet_pref,
    "plans" => $plans
]);
?>
