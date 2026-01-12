<?php
require 'config.php';

header('Content-Type: application/json');

$user_id = $_POST['user_id'] ?? $_GET['user_id'] ?? '';

if (empty($user_id)) {
    echo json_encode(["status" => "error", "message" => "User ID required"]);
    exit;
}

// 1. Get User Preference & Targets
$pref = $_POST['diet_preference'] ?? 'non-veg';
$target_cal_daily = 2200; // Default

$stmt = $conn->prepare("SELECT diet_preference, target_calories FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$res = $stmt->get_result();
if ($row = $res->fetch_assoc()) {
    if (empty($_POST['diet_preference']) && !empty($row['diet_preference'])) {
        $pref = $row['diet_preference'];
    }
    if (!empty($row['target_calories']) && $row['target_calories'] > 0) $target_cal_daily = $row['target_calories'];
}
$stmt->close();

$pref = strtolower($pref);
if (strpos($pref, 'non') !== false) $pref = 'non-veg';
else if (strpos($pref, 'veg') !== false) $pref = 'veg';
else $pref = 'veg'; 

// Helper to check timing suitability
function isTimeSuitable($name, $type) {
    $name = strtolower($name);
    if ($type == 'breakfast') {
        if (strpos($name, 'chicken') !== false || strpos($name, 'fish') !== false || strpos($name, 'biryani') !== false || strpos($name, 'meals') !== false || strpos($name, 'curry') !== false) return false; 
        return true; 
    }
    if ($type == 'lunch') return true; 
    if ($type == 'dinner') {
        if (strpos($name, 'pizza') !== false || strpos($name, 'burger') !== false) return false; 
        return true;
    }
    if ($type == 'snack') {
         if (strpos($name, 'rice') !== false || strpos($name, 'roti') !== false || strpos($name, 'curry') !== false || strpos($name, 'biryani') !== false) return false;
         return true;
    }
    return true;
}

// ---------------------------------------------------------
// NEW LOGIC: DYNAMIC SCALING (Auto-Sizing)
// ---------------------------------------------------------

$where_clause = "";
if ($pref == 'veg') {
    $where_clause = "LOWER(category) NOT LIKE '%non%' AND LOWER(category) NOT LIKE '%egg%' AND LOWER(food_name) NOT LIKE '%chicken%' AND LOWER(food_name) NOT LIKE '%mutton%' AND LOWER(food_name) NOT LIKE '%fish%' AND LOWER(food_name) NOT LIKE '%beef%'";
} else {
    $where_clause = "1=1"; 
}

$all_foods = [];
$query = "SELECT * FROM foods WHERE $where_clause";
$r = $conn->query($query);
if ($r) {
    while ($row = $r->fetch_assoc()) { $all_foods[] = $row; }
}
$used_food_names = [];
$current_total_cals = 0;
$current_total_pro = 0; // Fix: Initialize variable
$inserted_count = 0;

// Remove the dangerous fallback that loaded ALL foods if filtered list was empty.
// If filtered list is empty, we must NOT show forbidden foods. 
// We should rather exit or fail gracefully, or relax ONLY the keyword filters but keep the category filter.
if (empty($all_foods)) {
    // Try relaxed query: Only check major Categories for Veg, ignore complex name checks
    if ($pref == 'veg') {
         $query = "SELECT * FROM foods WHERE LOWER(category) NOT LIKE '%non%' AND LOWER(category) NOT LIKE '%egg%'";
         $r = $conn->query($query);
         while ($row = $r->fetch_assoc()) { $all_foods[] = $row; }
    } else {
         // If Non-Veg and empty?? Just load all.
         $query = "SELECT * FROM foods";
         $r = $conn->query($query);
         while ($row = $r->fetch_assoc()) { $all_foods[] = $row; }
    }
}

$meal_slots = [
    ['type' => 'breakfast', 'ratio' => 0.25],
    ['type' => 'lunch',     'ratio' => 0.35],
    ['type' => 'dinner',    'ratio' => 0.30],
    ['type' => 'snack',     'ratio' => 0.10]
];

$log = [];

foreach ($meal_slots as $index => $slot) {
    $type = $slot['type'];
    $is_last = ($index === count($meal_slots) - 1);
    
    // CUMULATIVE TARGETING
    // We want the total at the end of this meal to be: DailyTarget * Sum(Ratios)
    $cumulative_ratio = 0;
    for($i=0; $i<=$index; $i++) $cumulative_ratio += $meal_slots[$i]['ratio'];
    
    $cumulative_target = $target_cal_daily * $cumulative_ratio;
    
    // The specific target for THIS meal is the gap between where we should be and where we are
    $slot_target_cal = $cumulative_target - $current_total_cals;
    
    // Safety
    if ($slot_target_cal < 50) $slot_target_cal = 50;

    // MACRO AWARENESS: What ratio do we need?
    // User wants >90% accuracy on ALL nutrients.
    // If we are short on Protein, we MUST pick a high protein food.
    // Calculate required density for this slot to catch up
    $cum_pro_target_now = ($target_cal_daily * 0.20 / 4) * $cumulative_ratio; // Expected Pro by now
    $pro_needed = $cum_pro_target_now - $current_total_pro; // Approx Pro gap
    if ($pro_needed < 1) $pro_needed = 1;

    $req_pro_ratio = $pro_needed / $slot_target_cal; // e.g., 0.1 means 10g Pro per 100 Cal
    
    // Filter candidates based on this ratio
    $best_candidates = [];
    shuffle($all_foods);

    foreach ($all_foods as $food) {
        if (!isTimeSuitable($food['food_name'], $type)) continue;
        if (in_array($food['food_name'], $used_food_names)) continue;
        if ($food['calories'] < 10) continue;

        // Check Protein Density
        $this_pro_ratio = $food['protein'] / ($food['calories'] ?: 1);
        
        // If we really need protein ($req_pro_ratio > 0.05), discard foods that are too weak
        // But be lenient if we are just starting or ratio is low
        if ($req_pro_ratio > 0.05 && $this_pro_ratio < ($req_pro_ratio * 0.7)) {
            continue; // Skip this low protein food, it will blow up calories before hitting protein
        }

        $best_candidates[] = $food;
        if (count($best_candidates) > 5) break; // Found enough good options
    }

    // Fallback: If strict filter killed everyone, just pick random valid
    if (empty($best_candidates)) {
         foreach ($all_foods as $food) {
            if (!isTimeSuitable($food['food_name'], $type)) continue;
            if (in_array($food['food_name'], $used_food_names)) continue;
            $best_candidates[] = $food;
            if (count($best_candidates) > 0) break; 
         }
    }
    
    // If STILL empty (no foods suitable for time?), pick purely random
    if (empty($best_candidates)) {
        $selected_food = $all_foods[array_rand($all_foods)];
    } else {
        $selected_food = $best_candidates[array_rand($best_candidates)];
    }

    // SCALE IT
    // Ratio = Needed / Base
    $base_cal = $selected_food['calories'];
    if ($base_cal <= 0) $base_cal = 50; // Prevention

    $ratio = $slot_target_cal / $base_cal;
    
    $new_cal = $slot_target_cal; // Forced Exact
    $new_pro = ($selected_food['protein'] ?? 0) * $ratio;
    $new_carb = ($selected_food['carbs'] ?? 0) * $ratio;
    $new_fat = ($selected_food['fat'] ?? 0) * $ratio;
    
    // Generate Name with Portion hint
    $portion_desc = "";
    if ($ratio > 1.2) $portion_desc = " (Lg)";
    if ($ratio > 2.0) $portion_desc = " (x".round($ratio, 1).")";
    if ($ratio < 0.8) $portion_desc = " (Sm)";
    
    $final_name = $selected_food['food_name'] . $portion_desc;

    // Insert
    $ins = $conn->prepare("INSERT INTO meals (user_id, food_name, calories, protein, carbs, fat, meal_type, date, is_eaten) VALUES (?, ?, ?, ?, ?, ?, ?, CURDATE(), 0)");
    
    $ins->bind_param("isdddds", $user_id, $final_name, $new_cal, $new_pro, $new_carb, $new_fat, $type);
    if ($ins->execute()) {
        $inserted_count++;
        $current_total_cals += $new_cal;
        $current_total_pro += $new_pro;
        $used_food_names[] = $selected_food['food_name']; // Base name
        $log[] = "$type: $final_name ($new_cal)";
    }
    $ins->close();
}

$response_msg = "Generated $inserted_count meals. Target: $target_cal_daily. Achieved: ".round($current_total_cals);
echo json_encode(["status" => "success", "message" => $response_msg]);

$conn->close();
?>
