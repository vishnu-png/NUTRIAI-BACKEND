<?php
include 'config.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $user_id = $_POST['user_id'] ?? '';
    $food_name = $_POST['food_name'] ?? '';
    $meal_type = $_POST['meal_type'] ?? '';

    // AUTO NUTRIENTS (YOU DON'T ENTER THEM IN POSTMAN)
    $calories = $_POST['calories'] ?? 0;
    $protein = $_POST['protein'] ?? 0.0;
    $carbs = $_POST['carbs'] ?? 0.0;
    $fats = $_POST['fats'] ?? 0.0;
    $fiber = $_POST['fiber'] ?? 0.0;
    $sodium = $_POST['sodium'] ?? 0.0;

    $date = date("Y-m-d");

    $query = "INSERT INTO meals(user_id, food_name, meal_type, calories, protein, carbs, fat, fiber, sodium, date)
    VALUES('$user_id', '$food_name', '$meal_type', '$calories', '$protein', '$carbs', '$fats', '$fiber', '$sodium', '$date')";

    if(mysqli_query($conn, $query)){
        echo "Meal Added Successfully";
    } else {
        echo "Error Adding Meal";
    }

} else {
    echo "Invalid Request Method";
}
?>
