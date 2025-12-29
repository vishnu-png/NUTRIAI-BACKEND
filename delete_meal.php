<?php
include 'config.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $meal_id = $_POST['meal_id'] ?? '';

    if(empty($meal_id)){
        echo "Meal ID Missing";
        exit;
    }

    $query = "DELETE FROM meals WHERE id='$meal_id'";

    if(mysqli_query($conn, $query)){
        echo "Meal Deleted Successfully";
    } else {
        echo "Error Deleting Meal";
    }

} else {
    echo "Invalid Request Method";
}
?>
