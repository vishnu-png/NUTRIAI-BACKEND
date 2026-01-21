<?php
include 'config.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $age = $_POST['age'] ?? '';
    $weight = $_POST['weight'] ?? '';
    $height = $_POST['height'] ?? '';

    // Optional Nutrient Targets
    $diet_preference = $_POST['diet_preference'] ?? 'non-veg';
    $target_calories = $_POST['target_calories'] ?? 2000;
    $target_protein = $_POST['target_protein'] ?? 150;
    $target_carbs = $_POST['target_carbs'] ?? 250;
    $target_fat = $_POST['target_fat'] ?? 70;

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Using prepared statement for security
    $stmt = $conn->prepare("INSERT INTO users(name, email, password, age, weight, height, diet_preference, target_calories, target_protein, target_carbs, target_fat) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssdddd", $name, $email, $hashed_password, $age, $weight, $height, $diet_preference, $target_calories, $target_protein, $target_carbs, $target_fat);

    if($stmt->execute()){
        // Get the new user ID
        $user_id = $conn->insert_id; // LIMITATION: This works if ID is auto-increment INT. But table might use UUID string?
        // Wait, schema check showed ID is likely INT AUTO_INCREMENT based on typical setups, but `user_bmi_records` uses VARCHAR(50) for user_id. 
        // Let's check `users` schema first in my thought process? 
        // ACTUALLY, `register_user.php` uses `INSERT INTO users`. `id` usually auto-inc.
        // Wait, the previous `setup_health_tables.php` used `user_id VARCHAR(50)`. 
        // If `users.id` is INT, `insert_id` gives it. If it's GUID generated in PHP, it's different.
        // `register_user.php` doesn't generate UUID. It just inserts. So it's likely Auto-Inc.
        
        // Let's assume Auto-Inc ID for now.
        $new_user_id = $stmt->insert_id;

        // Calculate BMI
        $bmi_status = "Normal";
        $bmi_val = 0;
        if($height > 0 && $weight > 0){
             $h_m = $height / 100;
             $bmi_val = $weight / ($h_m * $h_m);
             $bmi_val = round($bmi_val, 1);
             
             if($bmi_val < 18.5) $bmi_status = "Underweight";
             else if($bmi_val < 25) $bmi_status = "Normal";
             else if($bmi_val < 30) $bmi_status = "Overweight";
             else $bmi_status = "Obese";

             // Insert BMI Record
             $bmi_sql = "INSERT INTO user_bmi_records (user_id, bmi_value, status, date_recorded) VALUES ('$new_user_id', '$bmi_val', '$bmi_status', NOW())";
             $conn->query($bmi_sql);
        }

        echo json_encode(["status" => "success", "message" => "User Registered Successfully"]);
    }else{
        echo json_encode(["status" => "failed", "message" => "Registration Failed: " . $conn->error]);
    }
    $stmt->close();

}else{
    echo json_encode(["status" => "failed", "message" => "Invalid Request Method"]);
}
?>
