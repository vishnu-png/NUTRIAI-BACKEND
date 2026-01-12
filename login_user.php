<?php
include 'config.php';

if (!isset($_POST['email']) || !isset($_POST['password'])) {
    echo json_encode(["status" => "failed", "message" => "Missing email or password"]);
    exit();
}

$email = $_POST['email'];
$password = $_POST['password'];

$query = "SELECT * FROM users WHERE email='$email'";
$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) > 0){
    $user = mysqli_fetch_assoc($result);

    if(password_verify($password, $user['password'])){
        echo json_encode([
            "status" => "success",
            "user_id" => $user['id'],
            "name" => $user['name'],
            "email" => $user['email'],
            "target_calories" => $user['target_calories'] ?? 2000,
            "diet_preference" => $user['diet_preference'] ?? 'Non-Veg'
        ]);
    }else{
        echo json_encode([
            "status" => "failed",
            "message" => "Invalid Password"
        ]);
    }
}else{
    echo json_encode([
        "status" => "failed",
        "message" => "User not found"
    ]);
}
?>
