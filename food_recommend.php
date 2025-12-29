<?php
include 'config.php';

$user_id = $_GET['user_id'] ?? '';

if(empty($user_id)){
    echo json_encode(["error" => "User ID Missing"]);
    exit;
}

// Calculate today's intake
$date = date("Y-m-d");
$query = "
SELECT 
    SUM(calories) AS calories,
    SUM(protein) AS protein,
    SUM(iron) AS iron,
    SUM(calcium) AS calcium
FROM meals
WHERE user_id='$user_id' AND date='$date'
";

$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

// Today's recommended amounts
$recommended = [
    "calories" => 2000,
    "protein" => 50,
    "iron" => 14,
    "calcium" => 1000
];

// Check deficiencies
$need = [];

foreach($recommended as $nut => $value){
    $need[$nut] = max(0, $value - $data[$nut]);
}

// Suggestions
$foods = [
    "protein" => "Eggs, Chicken, Dal, Paneer, Whey",
    "iron" => "Spinach, Beetroot, Dates, Broccoli",
    "calcium" => "Milk, Curd, Cheese, Ragi",
    "calories" => "Rice, Chapati, Potato, Banana"
];

$response = [
    "todays_need" => $need,
    "food_suggestions" => $foods
];

echo json_encode($response);
?>
