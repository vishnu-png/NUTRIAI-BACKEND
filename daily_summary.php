<?php
include 'config.php';

$user_id = $_GET['user_id'] ?? '';

if(empty($user_id)){
    echo json_encode(["error" => "User ID Missing"]);
    exit;
}

$date = date("Y-m-d");

// SUM all nutrients for today
$query = "SELECT 
            SUM(calories) AS total_calories,
            SUM(protein) AS total_protein,
            SUM(iron) AS total_iron,
            SUM(calcium) AS total_calcium,
            COUNT(*) AS meals_count
          FROM meals 
          WHERE user_id='$user_id' AND date='$date'";

$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

// Replace null with 0
foreach($data as $key => $value){
    if($value === null){
        $data[$key] = 0;
    }
}

echo json_encode($data);
?>
