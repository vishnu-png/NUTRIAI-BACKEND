<?php
require 'config.php';

$user_id = $_POST['user_id'] ?? $_GET['user_id'] ?? '';

if(empty($user_id)){
    echo json_encode(["status"=>"error", "message"=>"User ID required"]);
    exit;
}

$stmt = $conn->prepare("DELETE FROM meals WHERE user_id = ? AND date = CURDATE()");
$stmt->bind_param("i", $user_id);

if($stmt->execute()){
    echo json_encode(["status"=>"success", "message"=>"Cleared today's meals"]);
} else {
    echo json_encode(["status"=>"error", "message"=>"Failed to delete"]);
}
$conn->close();
?>
