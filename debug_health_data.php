<?php
require 'config.php';

echo "--- USERS ---\n";
$res = $conn->query("SELECT id, name, email, weight, height FROM users LIMIT 10");
while($row = $res->fetch_assoc()) {
    print_r($row);
}

echo "\n--- BMI RECORDS ---\n";
$res2 = $conn->query("SELECT * FROM user_bmi_records");
if ($res2->num_rows == 0) echo "No BMI records found.\n";
while($row = $res2->fetch_assoc()) {
    print_r($row);
}
?>
