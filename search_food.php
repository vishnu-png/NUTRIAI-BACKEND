<?php
include 'config.php';

$search = $_GET['search'] ?? '';

if(empty($search)){
    echo json_encode(["error" => "Search keyword missing"]);
    exit;
}

$search = mysqli_real_escape_string($conn, $search);

$query = "SELECT * FROM foods 
          WHERE food_name LIKE '%$search%' 
          ORDER BY food_name ASC 
          LIMIT 30";

$result = mysqli_query($conn, $query);

$foods = [];

while($row = mysqli_fetch_assoc($result)){
    $foods[] = $row;
}

if(empty($foods)){
    echo json_encode(["message" => "No matching foods found"]);
} else {
    echo json_encode($foods, JSON_PRETTY_PRINT);
}
?>
