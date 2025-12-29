<?php
include 'config.php';

$user_id = $_GET['user_id'];
$date = date("Y-m-d");

// Fetch total nutrients for the day
$query = "SELECT 
SUM(calories) as total_calories,
SUM(protein) as total_protein,
SUM(iron) as total_iron,
SUM(calcium) as total_calcium
FROM meals 
WHERE user_id='$user_id' AND date='$date'";

$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

// Daily recommended values (simple example)
$required_protein = 50;
$required_iron = 18;
$required_calcium = 1000;

// Deficiency check
$deficiencies = [];

if($data['total_protein'] < $required_protein){
    $deficiencies[] = "Low Protein";
}
if($data['total_iron'] < $required_iron){
    $deficiencies[] = "Low Iron";
}
if($data['total_calcium'] < $required_calcium){
    $deficiencies[] = "Low Calcium";
}

$message = count($deficiencies) > 0 
? "You have some nutritional deficiencies today" 
: "Your nutrition intake is balanced today";

echo json_encode([
    "calories" => $data['total_calories'] ?? 0,
    "protein" => $data['total_protein'] ?? 0,
    "iron" => $data['total_iron'] ?? 0,
    "calcium" => $data['total_calcium'] ?? 0,
    "deficiencies" => $deficiencies,
    "message" => $message
]);
?>
