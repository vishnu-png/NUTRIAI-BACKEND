<?php
header('Content-Type: application/json');
$response = [];

$response['php_version'] = phpversion();
$response['mysqli_installed'] = function_exists('mysqli_connect');
$response['display_errors'] = ini_get('display_errors');

if (function_exists('mysqli_connect')) {
    $conn = @mysqli_connect("localhost", "root", "", "nutriai");
    if ($conn) {
        $response['db_connection'] = "success";
        mysqli_close($conn);
    } else {
        $response['db_connection'] = "failed: " . mysqli_connect_error();
    }
} else {
    $response['db_connection'] = "failed: mysqli extension not installed";
}

echo json_encode($response);
?>
