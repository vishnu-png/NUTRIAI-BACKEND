<?php
require 'config.php';

$user_id = $_GET['user_id'] ?? '';

if (empty($user_id)) {
    echo json_encode(["status" => "failed", "message" => "User ID required"]);
    exit();
}

$response = ["status" => "success"];

// 1. Fetch BMI History
$bmi_sql = "SELECT * FROM user_bmi_records WHERE user_id = '$user_id' ORDER BY date_recorded DESC";
$bmi_res = $conn->query($bmi_sql);
$bmi_data = [];
while ($row = $bmi_res->fetch_assoc()) {
    $bmi_data[] = $row;
}

// BACKFILL: If no history exists, check if user has profile data and insert it now
if (empty($bmi_data)) {
    $user_sql = "SELECT weight, height FROM users WHERE id = '$user_id'";
    $u_res = $conn->query($user_sql);
    if ($u_res && $u_res->num_rows > 0) {
        $u_row = $u_res->fetch_assoc();
        $w = $u_row['weight'];
        $h = $u_row['height'];
        
        if (!empty($w) && !empty($h) && $h > 0) {
             $h_m = $h / 100;
             $bmi_val = round($w / ($h_m * $h_m), 1);
             
             $status = "Normal";
             if($bmi_val < 18.5) $status = "Underweight";
             else if($bmi_val < 25) $status = "Normal";
             else if($bmi_val < 30) $status = "Overweight";
             else $status = "Obese";

             // Insert
             $ins = "INSERT INTO user_bmi_records (user_id, bmi_value, status, date_recorded) VALUES ('$user_id', '$bmi_val', '$status', NOW())";
             if ($conn->query($ins)) {
                 // Fetch again
                 $new_res = $conn->query("SELECT * FROM user_bmi_records WHERE user_id = '$user_id'");
                 while ($r = $new_res->fetch_assoc()) {
                     $bmi_data[] = $r;
                 }
             }
        }
    }
}

$response['bmi_history'] = $bmi_data;

// 2. Fetch Deficiency Reports
$def_sql = "SELECT * FROM user_deficiency_reports WHERE user_id = '$user_id' ORDER BY date_recorded DESC";
$def_res = $conn->query($def_sql);
$def_data = [];
while ($row = $def_res->fetch_assoc()) {
    $def_data[] = $row;
}
$response['deficiency_reports'] = $def_data;

echo json_encode($response);
$conn->close();
?>
