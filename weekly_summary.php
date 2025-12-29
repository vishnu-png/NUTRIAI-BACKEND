<?php
include 'config.php';

$user_id = $_GET['user_id'] ?? '';

if(empty($user_id)){
    echo json_encode(["error" => "User ID Missing"]);
    exit;
}

// Get last 7 days
$query = "
SELECT 
    date,
    SUM(calories) AS calories,
    SUM(protein) AS protein,
    SUM(iron) AS iron,
    SUM(calcium) AS calcium
FROM meals
WHERE user_id='$user_id' 
      AND date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
GROUP BY date
ORDER BY date ASC";

$result = mysqli_query($conn, $query);

$weekly = [];

while($row = mysqli_fetch_assoc($result)){
    $weekly[] = $row;
}

echo json_encode($weekly);
?>
