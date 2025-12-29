<?php
include 'config.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $user_id = $_POST['user_id'] ?? '';
    $name = $_POST['name'] ?? '';
    $age = $_POST['age'] ?? '';
    $weight = $_POST['weight'] ?? '';
    $height = $_POST['height'] ?? '';

    if(empty($user_id)){
        echo "User ID Missing";
        exit;
    }

    $query = "UPDATE users 
              SET name='$name', age='$age', weight='$weight', height='$height'
              WHERE id='$user_id'";

    if(mysqli_query($conn, $query)){
        echo "Profile Updated Successfully";
    } else {
        echo "Error Updating Profile";
    }

} else {
    echo "Invalid Request Method";
}
?>
