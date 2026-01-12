<?php
require 'config.php';
header('Content-Type: application/json');

$user_id = $_GET['user_id'] ?? '';

if (empty($user_id)) {
    echo json_encode(["status" => "failed", "message" => "User ID required"]);
    exit();
}

// Just update the timestamp
$sql = "UPDATE users SET last_synced = NOW() WHERE id = '$user_id'";
if ($conn->query($sql)) {
    echo json_encode(["status" => "success", "message" => "Sync complete"]);
} else {
    echo json_encode(["status" => "failed", "message" => "Sync failed"]);
}
?>
