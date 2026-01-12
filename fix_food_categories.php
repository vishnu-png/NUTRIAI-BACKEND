<?php
require 'config.php';

echo "<h2>Fixing Food Categories...</h2>";

// 1. Force VEG
$veg_keywords = ['Idli', 'Dosa', 'Pongal', 'Rice', 'Dal', 'Paneer', 'Salad', 'Veg', 'Roti', 'Naan', 'Upma', 'Sambar', 'Curd', 'Milk', 'Apple', 'Banana', 'Oats', 'Khichdi', 'Chole', 'Bhature', 'Puri'];
foreach ($veg_keywords as $word) {
    $sql = "UPDATE foods SET category = 'veg' WHERE food_name LIKE '%$word%'";
    if ($conn->query($sql)) {
        echo "Marked '$word' items as VEG (Rows: " . $conn->affected_rows . ")<br>";
    }
}

// 2. Force NON-VEG
$nonveg_keywords = ['Chicken', 'Egg', 'Fish', 'Mutton', 'Prawn', 'Crab', 'Beef', 'Pork', 'Ham', 'Bacon', 'Steak', 'Omelette'];
foreach ($nonveg_keywords as $word) {
    $sql = "UPDATE foods SET category = 'non-veg' WHERE food_name LIKE '%$word%'";
    if ($conn->query($sql)) {
        echo "Marked '$word' items as NON-VEG (Rows: " . $conn->affected_rows . ")<br>";
    }
}

// 3. Verify Counts
echo "<h3>New Counts:</h3>";
$res = $conn->query("SELECT category, COUNT(*) as c FROM foods GROUP BY category");
while($row = $res->fetch_assoc()) {
    echo "[{$row['category']}]: {$row['c']} <br>";
}

// 4. Check for NULL/Empty
$nulls = $conn->query("SELECT COUNT(*) as c FROM foods WHERE category IS NULL OR category = ''")->fetch_assoc()['c'];
echo "Uncategorized Foods: $nulls <br>";

// 5. Default remaining to 'veg'? (Optional, maybe specific common items)
$conn->query("UPDATE foods SET category = 'veg' WHERE category IS NULL OR category = ''"); 

echo "Done.";
?>
