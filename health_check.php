<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require 'config.php';

echo "<h1>NutriAI Backend Health Check</h1>";

// 1. Check DB Connection
if ($conn->connect_error) {
    die("<p style='color:red'>Database Connection Failed: " . $conn->connect_error . "</p>");
}
echo "<p style='color:green'>Database Connection Successful</p>";

// 2. Check Foods Table
$res = $conn->query("SELECT COUNT(*) as c FROM foods");
if ($res) {
    $row = $res->fetch_assoc();
    $count = $row['c'];
    if ($count > 0) {
        echo "<p style='color:green'>Foods Table: OK ($count items)</p>";
    } else {
        echo "<p style='color:red'>Foods Table: EMPTY (0 items). Please import nutriai.sql!</p>";
    }
} else {
    echo "<p style='color:red'>Foods Table Query Failed: " . $conn->error . "</p>";
}

// 3. Check Meals Table (Recent)
$res = $conn->query("SELECT * FROM meals ORDER BY id DESC LIMIT 5");
echo "<h3>Recent 5 Meals Generated:</h3>";
if ($res && $res->num_rows > 0) {
    echo "<table border='1'><tr><th>ID</th><th>User ID</th><th>Food</th><th>Date</th></tr>";
    while ($row = $res->fetch_assoc()) {
        echo "<tr><td>{$row['id']}</td><td>{$row['user_id']}</td><td>{$row['food_name']}</td><td>{$row['date']}</td></tr>";
    }
    echo "</table>";
} else {
    echo "<p>No meals found.</p>";
}

?>
