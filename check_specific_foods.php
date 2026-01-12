<?php
require 'config.php';

$checks = ['Prawns', 'Mutton', 'Crab', 'Beef', 'Pork', 'Curry'];
foreach ($checks as $name) {
    $res = $conn->query("SELECT * FROM foods WHERE food_name LIKE '%$name%' LIMIT 3");
    while ($row = $res->fetch_assoc()) {
        echo "{$row['food_name']}: {$row['calories']} kcal, {$row['protein']}g P, {$row['carbs']}g C, {$row['fat']}g F\n";
    }
}
$conn->close();
?>
