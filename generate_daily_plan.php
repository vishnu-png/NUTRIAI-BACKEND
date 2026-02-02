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


// ... previous code ...
$all_foods = [];
$query = "SELECT * FROM foods WHERE $where_clause";
$r = $conn->query($query);
if ($r) {
    while ($row = $r->fetch_assoc()) { $all_foods[] = $row; }
}

// Validation: No Foods
if (count($all_foods) == 0) {
    // Try relaxed fallback if Veg
    if ($pref == 'veg') {
         $query = "SELECT * FROM foods WHERE LOWER(category) NOT LIKE '%non%' AND LOWER(category) NOT LIKE '%egg%'";
         $r = $conn->query($query);
         while ($row = $r->fetch_assoc()) { $all_foods[] = $row; }
    }
    
    // Final check
    if (count($all_foods) == 0) {
        $check_total = $conn->query("SELECT COUNT(*) as c FROM foods")->fetch_assoc()['c'];
        $msg = ($check_total == 0) ? "No foods in database. Please import nutriai.sql" : "No suitable foods found for preference: $pref";
        echo json_encode(["status" => "failed", "message" => $msg]);
        exit;
    }
}

$used_food_names = [];
$current_total_cals = 0;
$current_total_pro = 0; 
$inserted_count = 0;

$meal_slots = [
    ['type' => 'breakfast', 'ratio' => 0.25],
    ['type' => 'lunch',     'ratio' => 0.35],
    ['type' => 'dinner',    'ratio' => 0.30],
    ['type' => 'snack',     'ratio' => 0.10]
];

$log = [];

foreach ($meal_slots as $index => $slot) {
    // ... (rest of logic same until selection) ...
    $type = $slot['type'];
    
    // ... selection logic ...
    // Copy existing loop internal logic but Ensure $all_foods is not empty which we did above.
    
    // CUMULATIVE TARGETING
    $cumulative_ratio = 0;
    for($i=0; $i<=$index; $i++) $cumulative_ratio += $meal_slots[$i]['ratio'];
    
    $cumulative_target = $target_cal_daily * $cumulative_ratio;
    $slot_target_cal = $cumulative_target - $current_total_cals;
    if ($slot_target_cal < 50) $slot_target_cal = 50;

    $cum_pro_target_now = ($target_cal_daily * 0.20 / 4) * $cumulative_ratio;
    $pro_needed = $cum_pro_target_now - $current_total_pro;
    if ($pro_needed < 1) $pro_needed = 1;

    $req_pro_ratio = $pro_needed / $slot_target_cal;

    $best_candidates = [];
    shuffle($all_foods);

    foreach ($all_foods as $food) {
        if (!isTimeSuitable($food['food_name'], $type)) continue;
        if (in_array($food['food_name'], $used_food_names)) continue;
        if ($food['calories'] < 10) continue;

        $this_pro_ratio = $food['protein'] / ($food['calories'] ?: 1);
        if ($req_pro_ratio > 0.05 && $this_pro_ratio < ($req_pro_ratio * 0.7)) continue;

        $best_candidates[] = $food;
        if (count($best_candidates) > 5) break;
    }

    if (empty($best_candidates)) {
         foreach ($all_foods as $food) {
            if (!isTimeSuitable($food['food_name'], $type)) continue;
            if (in_array($food['food_name'], $used_food_names)) continue;
            $best_candidates[] = $food;
            if (count($best_candidates) > 0) break; 
         }
    }
    
    // Safe Random Pick
    $selected_food = null;
    if (!empty($best_candidates)) {
        $selected_food = $best_candidates[array_rand($best_candidates)];
    } else {
        // Last resort: Any random food
        if (!empty($all_foods)) {
            $selected_food = $all_foods[array_rand($all_foods)];
        }
    }

    if (!$selected_food) continue; // Skip slot if absolutely nothing found

    // SCALE IT
    $base_cal = $selected_food['calories'];
    if ($base_cal <= 0) $base_cal = 50; 

    $ratio = $slot_target_cal / $base_cal;
    
    $new_cal = $slot_target_cal; 
    $new_pro = ($selected_food['protein'] ?? 0) * $ratio;
    $new_carb = ($selected_food['carbs'] ?? 0) * $ratio;
    $new_fat = ($selected_food['fat'] ?? 0) * $ratio;
    
    $portion_desc = "";
    if ($ratio > 1.2) $portion_desc = " (Lg)";
    if ($ratio > 2.0) $portion_desc = " (x".round($ratio, 1).")";
    if ($ratio < 0.8) $portion_desc = " (Sm)";
    
    $final_name = $selected_food['food_name'] . $portion_desc;

    // Insert - Use 's' for user_id to be safe
    $ins = $conn->prepare("INSERT INTO meals (user_id, food_name, calories, protein, carbs, fat, meal_type, date, is_eaten) VALUES (?, ?, ?, ?, ?, ?, ?, CURDATE(), 0)");
    
    // Bind 's' for user_id to match string/int flexibility
    $ins->bind_param("ssdddds", $user_id, $final_name, $new_cal, $new_pro, $new_carb, $new_fat, $type);
    if ($ins->execute()) {
        $inserted_count++;
        $current_total_cals += $new_cal;
        $current_total_pro += $new_pro;
        $used_food_names[] = $selected_food['food_name'];
        $log[] = "$type: $final_name ($new_cal)";
    }
    $ins->close();
}

if ($inserted_count == 0) {
    echo json_encode(["status" => "failed", "message" => "Could not generate any meals. Logic found no suitable candidates."]);
} else {
    $response_msg = "Generated $inserted_count meals. Target: $target_cal_daily. Achieved: ".round($current_total_cals);
    echo json_encode(["status" => "success", "message" => $response_msg]);
}

$conn->close();

?>
