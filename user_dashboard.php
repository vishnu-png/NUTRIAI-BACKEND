<?php
include 'config.php';

$user_id = $_GET['user_id'];
$date = date("Y-m-d");

$query = "SELECT 
COUNT(id) as total_meals,
SUM(calories) as total_calories,
SUM(protein) as total_protein,
SUM(iron) as total_iron,
SUM(calcium) as total_calcium
FROM meals 
WHERE user_id='$user_id' AND date='$date'";

$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

echo json_encode([
    "total_meals" => $data['total_meals'] ?? 0,
    "calories" => $data['total_calories'] ?? 0,
    "protein" => $data['total_protein'] ?? 0,
    "iron" => $data['total_iron'] ?? 0,
    "calcium" => $data['total_calcium'] ?? 0
]);
?>
