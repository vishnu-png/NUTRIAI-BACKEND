<?php
require_once 'config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $target_calories = $_POST['target_calories'];
    $target_protein = $_POST['target_protein'];
    $target_carbs = $_POST['target_carbs'];
    $target_fat = $_POST['target_fat'];
    $diet_preference = isset($_POST['diet_preference']) ? $_POST['diet_preference'] : null;

    if (empty($user_id)) {
        echo json_encode(['status' => 'error', 'message' => 'User ID is required']);
        exit;
    }

    // Build query dynamically based on inputs
    $sql = "UPDATE users SET target_calories = ?, target_protein = ?, target_carbs = ?, target_fat = ?";
    $params = [$target_calories, $target_protein, $target_carbs, $target_fat];
    $types = "iddd"; // int, decimal, decimal, decimal

    if ($diet_preference) {
        $sql .= ", diet_preference = ?";
        $params[] = $diet_preference;
        $types .= "s";
    }

    $sql .= " WHERE id = ?";
    $params[] = $user_id;
    $types .= "i";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Targets updated successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $conn->error]);
    }

    $stmt->close();
    $conn->close();
}
?>
