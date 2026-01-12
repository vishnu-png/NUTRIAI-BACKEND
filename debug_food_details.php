<?php
require 'config.php';

echo "<h2>Food Data Inspection</h2>";

$foods = [
    'Burger Chicken', 
    'Chole Bhature', 
    'Idli'
];

foreach ($foods as $name) {
    $name = $conn->real_escape_string($name);
    $sql = "SELECT * FROM foods WHERE food_name LIKE '%$name%'";
    $res = $conn->query($sql);
    
    echo "<h3>Searching for: $name</h3>";
    if ($res->num_rows > 0) {
        while ($row = $res->fetch_assoc()) {
            echo "Name: {$row['food_name']} <br>";
            echo "Category: <b style='color:red'>{$row['category']}</b> <br>";
            echo "Calories: {$row['calories']} <br>";
            echo "Carbs: <b>{$row['carbs']}g</b> <br>";
            echo "Fat: <b>{$row['fat']}g</b> <br>"; // Check column name carefully (fat vs fats)
            echo "Protein: {$row['protein']}g <br>";
            echo "<hr>";
        }
    } else {
        echo "Not found.<br>";
    }
}

// Also check column names
echo "<h3>Table Structure (Foods)</h3>";
$res = $conn->query("DESCRIBE foods");
while($row = $res->fetch_assoc()) {
    echo "{$row['Field']} ({$row['Type']}) <br>";
}

echo "<h3>Table Structure (Meals)</h3>";
$res = $conn->query("DESCRIBE meals");
while($row = $res->fetch_assoc()) {
    echo "{$row['Field']} ({$row['Type']}) <br>";
}
?>
