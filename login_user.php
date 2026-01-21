<?php
include 'config.php';

if (!isset($_POST['email']) || !isset($_POST['password'])) {
    echo json_encode(["status" => "failed", "message" => "Missing email or password"]);
    exit();
}

$email = $_POST['email'];
$password = $_POST['password'];

// Use Prepared Statement to prevent SQL Injection
$stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows > 0){
    $user = $result->fetch_assoc();

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
$stmt->close();
?>
