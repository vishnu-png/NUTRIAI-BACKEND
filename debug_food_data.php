<?php
require 'config.php';

echo "<h2>Food Database Status</h2>";

// Count total foods
$total = $conn->query("SELECT COUNT(*) as c FROM foods")->fetch_assoc()['c'];
echo "Total Foods: $total <br>";

// Count by category
$cats = $conn->query("SELECT category, COUNT(*) as c FROM foods GROUP BY category");
echo "<h3>By Category:</h3>";
while($row = $cats->fetch_assoc()) {
    echo "Category [{$row['category']}]: {$row['c']} <br>";
}

// Show sample foods
echo "<h3>Sample Foods:</h3>";
$res = $conn->query("SELECT * FROM foods LIMIT 10");
while($row = $res->fetch_assoc()) {
    echo "{$row['food_name']} ({$row['category']}) - {$row['calories']} kcal <br>";
}
?>
