<?php
require 'config.php';

$id = $_POST['id'] ?? '';
$type = $_POST['type'] ?? ''; // 'bmi' or 'deficiency'

if (empty($id) || empty($type)) {
    echo json_encode(["status" => "failed", "message" => "ID and Type required"]);
    exit();
}

$table = ($type === 'bmi') ? 'user_bmi_records' : 'user_deficiency_reports';
$sql = "DELETE FROM $table WHERE id = $id";

if ($conn->query($sql)) {
    echo json_encode(["status" => "success", "message" => "Record deleted"]);
} else {
    echo json_encode(["status" => "failed", "message" => "Error deleting: " . $conn->error]);
}

$conn->close();
?>
