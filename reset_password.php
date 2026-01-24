<?php
include 'config.php';

// Standardize response to JSON
header('Content-Type: application/json');

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    // Get JSON body if sent as JSON, or POST vars if sent as Form
    $input = json_decode(file_get_contents('php://input'), true);
    
    $email = $input['email'] ?? $_POST['email'] ?? '';
    $new_password = $input['new_password'] ?? $_POST['new_password'] ?? '';

    if(empty($email) || empty($new_password)){
        echo json_encode(["status" => "failed", "message" => "Missing email or new password"]);
        exit();
    }

    // Check if email exists
    $check_query = "SELECT id FROM users WHERE email='$email'";
    $check_result = mysqli_query($conn, $check_query);
    
    if(mysqli_num_rows($check_result) == 0){
        echo json_encode(["status" => "failed", "message" => "Email not found"]);
        exit();
    }

    // Hash new password
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Update password
    $update_query = "UPDATE users SET password='$hashed_password' WHERE email='$email'";

    if(mysqli_query($conn, $update_query)){
        echo json_encode(["status" => "success", "message" => "Password updated successfully"]);
    } else {
        echo json_encode(["status" => "failed", "message" => "Database error: " . mysqli_error($conn)]);
    }

} else {
    echo json_encode(["status" => "failed", "message" => "Invalid Request Method"]);
}
?>
