<?php
require 'config.php';
header('Content-Type: text/plain');

echo "--- COLUMNS foods ---\n";
$res = $conn->query("DESCRIBE foods");
while($row = $res->fetch_assoc()) {
    echo $row['Field'] . "\n";
}

echo "\n--- COLUMNS meals ---\n";
$res = $conn->query("DESCRIBE meals");
while($row = $res->fetch_assoc()) {
    echo $row['Field'] . "\n";
}

echo "\n--- DATA Check ---\n";
$foods = ['Burger', 'Chole', 'Idli'];
foreach ($foods as $name) {
    echo "Search: $name\n";
    $sql = "SELECT * FROM foods WHERE food_name LIKE '%$name%' LIMIT 1";
    $row = $conn->query($sql)->fetch_assoc();
    if($row) {
        print_r($row);
    } else {
        echo "Not Found\n";
    }
    echo "----------------\n";
}
?>
