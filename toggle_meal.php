<?php
require 'config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $meal_id = $_POST['meal_id'];
    $is_eaten = $_POST['is_eaten']; // 0 or 1

    if (empty($meal_id)) {
        echo json_encode(["status" => "error", "message" => "Meal ID is required"]);
        exit;
    }

    $stmt = $conn->prepare("UPDATE meals SET is_eaten = ? WHERE id = ?");
    $stmt->bind_param("ii", $is_eaten, $meal_id);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Meal updated"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
}
?>
