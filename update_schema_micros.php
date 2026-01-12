<?php
require 'config.php';

$micros = ['iron', 'calcium', 'vitamin_d'];
$tables = ['foods', 'meals'];

foreach ($tables as $table) {
    echo "<h3>Updating $table...</h3>";
    foreach ($micros as $micro) {
        // Check if column exists
        $check = $conn->query("SHOW COLUMNS FROM $table LIKE '$micro'");
        if ($check->num_rows == 0) {
            $sql = "ALTER TABLE $table ADD COLUMN $micro DOUBLE DEFAULT 0";
            if ($conn->query($sql)) {
                echo "Added column: $micro <br>";
            } else {
                echo "Error adding $micro: " . $conn->error . "<br>";
            }
        } else {
            echo "Column $micro already exists.<br>";
        }
    }
}

echo "<h3>Seeding Data...</h3>";
// Seed some values
$seeds = [
    // Name, Iron (mg), Calcium (mg), Vit D (IU)
    ['Milk', 0.1, 300, 100],
    ['Curd', 0.2, 150, 0],
    ['Paneer', 0.5, 200, 0],
    ['Egg', 1.8, 50, 40],
    ['Chicken', 1.0, 15, 5],
    ['Fish', 0.5, 20, 400], // High Vit D
    ['Spinach', 3.0, 100, 0], // High Iron
    ['Dal', 2.0, 30, 0],
    ['Rice', 0.5, 10, 0],
    ['Roti', 1.5, 20, 0],
    ['Orange', 0.2, 40, 0],
    ['Apple', 0.2, 10, 0],
    ['Banana', 0.3, 5, 0]
];

foreach ($seeds as $item) {
    $name = $item[0];
    $iron = $item[1];
    $calc = $item[2];
    $vitd = $item[3];
    
    $sql = "UPDATE foods SET iron = $iron, calcium = $calc, vitamin_d = $vitd WHERE food_name LIKE '%$name%'";
    if ($conn->query($sql)) {
        echo "Updated $name (Rows: " . $conn->affected_rows . ")<br>";
    }
}

echo "Done.";
?>
