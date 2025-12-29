<?php
include 'config.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $user_id = $_POST['user_id'] ?? '';
    $food_name = $_POST['food_name'] ?? '';
    $meal_type = $_POST['meal_type'] ?? '';

    // AUTO NUTRIENTS (YOU DON'T ENTER THEM IN POSTMAN)
    $calories = 200;
    $protein = 10;
    $iron = 2;
    $calcium = 50;

    $date = date("Y-m-d");

    $query = "INSERT INTO meals(user_id, food_name, meal_type, calories, protein, iron, calcium, date)
    VALUES('$user_id', '$food_name', '$meal_type', '$calories', '$protein', '$iron', '$calcium', '$date')";

    if(mysqli_query($conn, $query)){
        echo "Meal Added Successfully";
    } else {
        echo "Error Adding Meal";
    }

} else {
    echo "Invalid Request Method";
}
?>
