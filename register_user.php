<?php
include 'config.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $age = $_POST['age'] ?? '';
    $weight = $_POST['weight'] ?? '';
    $height = $_POST['height'] ?? '';

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO users(name, email, password, age, weight, height)
    VALUES('$name','$email','$hashed_password','$age','$weight','$height')";

    if(mysqli_query($conn, $query)){
        echo "User Registered Successfully";
    }else{
        echo "Registration Failed";
    }

}else{
    echo "Invalid Request Method";
}
?>
