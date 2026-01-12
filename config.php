<?php
// Prevent HTML errors from corrupting JSON
error_reporting(0);
ini_set('display_errors', 0);
header('Content-Type: application/json');

try {
    $conn = mysqli_connect("localhost", "root", "", "nutriai");
} catch (Exception $e) {
    echo json_encode(["status" => "failed", "message" => "Database connection failed: " . $e->getMessage()]);
    exit();
}
?>
