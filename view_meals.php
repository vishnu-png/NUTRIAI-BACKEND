<?php
include 'config.php';

$user_id = $_GET['user_id'];
$date = date("Y-m-d");

$query = "SELECT * FROM meals WHERE user_id='$user_id' AND date='$date'";
$result = mysqli_query($conn, $query);

$meals = [];

while($row = mysqli_fetch_assoc($result)){
    $meals[] = $row;
}

echo json_encode($meals);
?>
