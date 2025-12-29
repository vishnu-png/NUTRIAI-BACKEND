<?php
include 'config.php';

header('Content-Type: application/json');

$user_id = $_GET['user_id'] ?? '';

if(empty($user_id)){
    echo json_encode(["error" => "User ID Missing"]);
    exit;
}

// Fetch user profile
$user_query = mysqli_query($conn, "SELECT id, name, email, age, weight, height FROM users WHERE id='$user_id'");
$user_data = mysqli_fetch_assoc($user_query);

if(!$user_data){
    echo json_encode(["error" => "User Not Found"]);
    exit;
}

// Fetch meals
$meal_query = mysqli_query($conn, "SELECT * FROM meals WHERE user_id='$user_id'");
$meals = [];

while($row = mysqli_fetch_assoc($meal_query)){
    $meals[] = $row;
}

// Summary
$summary_query = mysqli_query($conn, 
    "SELECT 
        SUM(calories) as total_calories,
        SUM(protein) as total_protein,
        SUM(iron) as total_iron,
        SUM(calcium) as total_calcium
    FROM meals
    WHERE user_id='$user_id'"
);

$summary = mysqli_fetch_assoc($summary_query);

// FINAL OUTPUT
$response = [
    "user_profile" => $user_data,
    "meals" => $meals,
    "summary" => $summary,
    "backup_date" => date("Y-m-d H:i:s")
];

echo json_encode($response, JSON_PRETTY_PRINT);
?>
