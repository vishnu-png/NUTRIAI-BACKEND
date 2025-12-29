<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo "Invalid Request Method";
    exit;
}

$user_id = $_POST['user_id'] ?? '';
$food_id = $_POST['food_id'] ?? '';
$meal_type = $_POST['meal_type'] ?? '';

if (empty($user_id) || empty($food_id) || empty($meal_type)) {
    echo "Missing Fields";
    exit;
}

// Fetch food details from database
$food_query = mysqli_query($conn, "SELECT * FROM foods WHERE id='$food_id'");
$food = mysqli_fetch_assoc($food_query);

if (!$food) {
    echo "Food Not Found";
    exit;
}

// Extract nutrient values
$food_name = $food['food_name'];
$calories = $food['calories'];
$protein = $food['protein'];
$iron = $food['iron'];
$calcium = $food['calcium'];
$date = date("Y-m-d");

// Insert into meals table
$insert = "
    INSERT INTO meals (user_id, meal_type, food_name, calories, protein, iron, calcium, date)
    VALUES ('$user_id', '$meal_type', '$food_name', '$calories', '$protein', '$iron', '$calcium', '$date')
";

if (mysqli_query($conn, $insert)) {
    echo "Meal Added Automatically";
} else {
    echo "Error Adding Meal";
}
?>
