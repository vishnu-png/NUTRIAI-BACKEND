<?php
include 'config.php';

$user_id = $_GET['user_id'];

// Last 7 days graph data
$query = "SELECT 
date,
SUM(calories) as calories,
SUM(protein) as protein,
SUM(iron) as iron,
SUM(calcium) as calcium
FROM meals 
WHERE user_id='$user_id'
GROUP BY date
ORDER BY date DESC
LIMIT 7";

$result = mysqli_query($conn, $query);

$graphData = [];

while($row = mysqli_fetch_assoc($result)){
    $graphData[] = $row;
}

echo json_encode(array_reverse($graphData));
?>
