<?php
require 'config.php';

$user_id = $_POST['user_id'] ?? '';
$food_name = $_POST['food_name'] ?? '';
$calories = $_POST['calories'] ?? 0;
$protein = $_POST['protein'] ?? 0;
$carbs = $_POST['carbs'] ?? 0;
$fat = $_POST['fat'] ?? 0;
$iron = $_POST['iron'] ?? 0;
$calcium = $_POST['calcium'] ?? 0;
$vitamin_d = $_POST['vitamin_d'] ?? 0;
$meal_type = $_POST['meal_type'] ?? 'Snack';
$date = date('Y-m-d');

if (!$user_id || !$food_name) {
    echo json_encode(['error' => 'Missing data']);
    exit;
}

$stmt = $conn->prepare("INSERT INTO meals (user_id, food_name, calories, protein, carbs, fat, iron, calcium, vitamin_d, meal_type, date, is_eaten) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0)");
$stmt->bind_param("ssdddddddss", $user_id, $food_name, $calories, $protein, $carbs, $fat, $iron, $calcium, $vitamin_d, $meal_type, $date);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['error' => $conn->error]);
}
?>
