<?php
include 'config.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $meal_id = $_POST['meal_id'] ?? '';
    $food_name = $_POST['food_name'] ?? '';
    $meal_type = $_POST['meal_type'] ?? '';

    if(empty($meal_id)){
        echo "Meal ID Missing";
        exit;
    }

    $query = "UPDATE meals 
              SET food_name='$food_name', meal_type='$meal_type' 
              WHERE id='$meal_id'";

    if(mysqli_query($conn, $query)){
        echo "Meal Updated Successfully";
    } else {
        echo "Error Updating Meal";
    }

} else {
    echo "Invalid Request Method";
}
?>
