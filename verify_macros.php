<?php
require 'config.php';

// 1. Spot Check
$checks = ['Rice', 'Chicken', 'Samosa', 'Pizza', 'Milk'];
foreach ($checks as $name) {
    $res = $conn->query("SELECT * FROM foods WHERE food_name LIKE '%$name%' LIMIT 1");
    if ($row = $res->fetch_assoc()) {
        echo "{$row['food_name']}: {$row['protein']}g P, {$row['carbs']}g C, {$row['fat']}g F\n";
    }
}

// 2. Remaining Zero Macro Items
$res = $conn->query("SELECT COUNT(*) as count FROM foods WHERE protein = 0 AND carbs = 0 AND fat = 0");
$row = $res->fetch_assoc();
echo "Items with ALL 0 macros: " . $row['count'] . "\n";

// 3. Show some remaining items
if ($row['count'] > 0) {
    echo "Sample un-updated items:\n";
    $res = $conn->query("SELECT food_name FROM foods WHERE protein = 0 AND carbs = 0 AND fat = 0 LIMIT 5");
    while($r = $res->fetch_assoc()) {
        echo "- " . $r['food_name'] . "\n";
    }
}

$conn->close();
?>
