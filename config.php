<?php
// Prevent HTML errors from corrupting JSON
error_reporting(0);
ini_set('display_errors', 0);
header('Content-Type: application/json');

try {
    // EDIT THESE FOR YOUR SERVER
    $DB_HOST = "localhost";
    $DB_USER = "root";
    $DB_PASS = "";
    $DB_NAME = "nutriai";

    $conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
} catch (Exception $e) {
    echo json_encode(["status" => "failed", "message" => "Database connection failed: " . $e->getMessage()]);
    exit();
}
?>
