<?php
include 'config.php';

$user_id = $_GET['user_id'];

$query = "SELECT * FROM meals WHERE user_id='$user_id' ORDER BY date DESC";
$result = mysqli_query($conn, $query);

$meals = [];

while($row = mysqli_fetch_assoc($result)){
    $meals[] = $row;
}

echo json_encode($meals);
?>
