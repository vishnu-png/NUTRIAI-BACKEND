<?php
require 'config.php';

// 1. BMI History Table
$sql_bmi = "CREATE TABLE IF NOT EXISTS user_bmi_records (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id VARCHAR(50) NOT NULL,
    bmi_value DECIMAL(5, 2) NOT NULL,
    status VARCHAR(50),
    date_recorded DATETIME DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql_bmi)) {
    echo "Table 'user_bmi_records' created or exists.\n";
} else {
    echo "Error creating table: " . $conn->error . "\n";
}

// 2. Deficiency Reports Table
$sql_deficiency = "CREATE TABLE IF NOT EXISTS user_deficiency_reports (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id VARCHAR(50) NOT NULL,
    nutrient_name VARCHAR(50) NOT NULL,
    deficiency_level VARCHAR(50), -- e.g. Mild, Moderate
    status VARCHAR(50), -- e.g. 'Low', 'Deficient'
    trend VARCHAR(20), -- 'up', 'down', 'stable'
    date_recorded DATETIME DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql_deficiency)) {
    echo "Table 'user_deficiency_reports' created or exists.\n";
} else {
    echo "Error creating table: " . $conn->error . "\n";
}

// 3. Insert Dummy Data (for testing)
$user_id = 'user_123'; // Example
$conn->query("INSERT INTO user_bmi_records (user_id, bmi_value, status, date_recorded) VALUES ('$user_id', 23.5, 'Normal', NOW())");
$conn->query("INSERT INTO user_deficiency_reports (user_id, nutrient_name, deficiency_level, status, trend, date_recorded) VALUES ('$user_id', 'Iron', 'Moderate', 'Low', 'down', NOW())");

echo "Dummy data inserted for testing.\n";

$conn->close();
?>
