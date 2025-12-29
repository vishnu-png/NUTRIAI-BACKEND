<?php
include 'config.php';

$user_id = $_GET['user_id'];

// Analyze last 7 days
$query = "SELECT 
AVG(protein) as avg_protein,
AVG(iron) as avg_iron,
AVG(calcium) as avg_calcium
FROM meals 
WHERE user_id='$user_id' AND date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)";

$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

// Threshold values
$protein_threshold = 50;
$iron_threshold = 18;
$calcium_threshold = 1000;

$predictions = [];

if($data['avg_protein'] < $protein_threshold){
    $predictions[] = "High risk of Protein Deficiency";
}

if($data['avg_iron'] < $iron_threshold){
    $predictions[] = "Risk of Iron Deficiency (Anemia)";
}

if($data['avg_calcium'] < $calcium_threshold){
    $predictions[] = "Low Calcium levels detected";
}

if(empty($predictions)){
    $predictions[] = "Balanced nutrition pattern detected";
}

echo json_encode([
    "weekly_avg_protein" => $data['avg_protein'] ?? 0,
    "weekly_avg_iron" => $data['avg_iron'] ?? 0,
    "weekly_avg_calcium" => $data['avg_calcium'] ?? 0,
    "predictions" => $predictions
]);
?>
