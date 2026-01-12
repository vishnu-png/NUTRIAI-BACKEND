<?php
include 'config.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $user_id = $_POST['user_id'] ?? '';
    $name = $_POST['name'] ?? '';
    $age = $_POST['age'] ?? '';
    $weight = $_POST['weight'] ?? '';
    $height = $_POST['height'] ?? '';
    $diet_preference = $_POST['diet_preference'] ?? '';

    if(empty($user_id)){
        echo json_encode(["status" => "error", "message" => "User ID Missing"]);
        exit;
    }

    // Recalculate Target Calories (Mifflin-St Jeor Equation)
    // Safe Fallback: Check if gender is passed, else use Neutral/Male baseline to avoid DB column crash if 'gender' missing.
    $gender = $_POST['gender'] ?? 'male'; // Default to male baseline if unknown (safest for sufficiency)
    
    // BMR Calc
    // Male: 10*W + 6.25*H - 5*A + 5
    // Female: 10*W + 6.25*H - 5*A - 161
    $w = floatval($weight);
    $h = floatval($height);
    $a = intval($age);
    
    $bmr = 0;
    if ($w > 0 && $h > 0 && $a > 0) {
        $bmr = (10 * $w) + (6.25 * $h) - (5 * $a);
        if (strtolower($gender) == 'female') {
            $bmr -= 161;
        } else {
            $bmr += 5;
        }
    } else {
        // Fallback if bad stats
        $bmr = 1600; 
    }
    
    // TDEE (Assume Sedentary/Light Active 1.25 for baseline if not specified)
    $tdee = $bmr * 1.375; // Moderate
    $new_target = round($tdee);
    
    if ($new_target < 1200) $new_target = 1200; // Floor

    // Use prepared statement for update
    // Remove diet_preference if not passed or handle it
    // The previous code assumed diet_preference is always passed.
    
    $query = "UPDATE users 
              SET name=?, age=?, weight=?, height=?, diet_preference=?, target_calories=?
              WHERE id=?";
              
    $stmt = $conn->prepare($query);
    if (!$stmt) {
         echo json_encode(["status" => "error", "message" => "Prepare Failed: " . $conn->error]);
         exit;
    }
    
    $stmt->bind_param("siddsii", $name, $age, $weight, $height, $diet_preference, $new_target, $user_id);

    if($stmt->execute()){
         // BMI Logic
         if($w > 0 && $h > 0){
             $h_m = $h / 100;
             $bmi_val = round($w / ($h_m * $h_m), 1);
             $bmi_status = ($bmi_val < 18.5) ? "Underweight" : (($bmi_val < 25) ? "Normal" : (($bmi_val < 30) ? "Overweight" : "Obese"));
             
             $bmi_sql = "INSERT INTO user_bmi_records (user_id, bmi_value, status, date_recorded) VALUES (?, ?, ?, NOW())";
             $b_stmt = $conn->prepare($bmi_sql);
             $b_stmt->bind_param("ids", $user_id, $bmi_val, $bmi_status);
             $b_stmt->execute();
         }
         
        echo json_encode([
            "status" => "success", 
            "message" => "Profile Updated",
            "new_target" => $new_target
        ]);
    } else {
        echo json_encode(["status" => "error", "message" => "DB Error: " . $conn->error]);
    }
    $stmt->close();

} else {
    echo json_encode(["status" => "error", "message" => "Invalid Request"]);
}
?>
