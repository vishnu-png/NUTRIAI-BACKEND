<?php
include 'config.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $user_id = $_POST['user_id'] ?? '';
    $old_password = $_POST['old_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';

    if(empty($user_id) || empty($old_password) || empty($new_password)){
        echo "Missing Fields";
        exit;
    }

    // Fetch existing password
    $query = "SELECT password FROM users WHERE id='$user_id'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    if(!$row){
        echo "User Not Found";
        exit;
    }

    $db_pass = $row['password'];

    // Allow both hashed and plain text comparison
    if($old_password !== $db_pass && !password_verify($old_password, $db_pass)){
        echo "Old Password Incorrect";
        exit;
    }

    // Hash new password
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Update password
    $update_query = "UPDATE users SET password='$hashed_password' WHERE id='$user_id'";

    if(mysqli_query($conn, $update_query)){
        echo "Password Updated Successfully";
    } else {
        echo "Error Updating Password";
    }

} else {
    echo "Invalid Request Method";
}
?>
