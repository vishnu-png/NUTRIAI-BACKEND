<?php
include 'config.php';

if($_SERVER['REQUEST_METHOD'] != 'POST'){
    echo "Invalid Request Method";
    exit;
}

if(!isset($_FILES['backup_file'])){
    echo "Backup File Missing";
    exit;
}

// Read uploaded JSON file
$json = file_get_contents($_FILES['backup_file']['tmp_name']);
$data = json_decode($json, true);

if(!$data){
    echo "Invalid JSON File";
    exit;
}

// Restore user profile
$user = $data["user_profile"];

$user_id = $user["id"];
$name = $user["name"];
$email = $user["email"];
$age = $user["age"];
$weight = $user["weight"];
$height = $user["height"];

mysqli_query($conn,
    "UPDATE users SET 
        name='$name',
        email='$email',
        age='$age',
        weight='$weight',
        height='$height'
    WHERE id='$user_id'"
);

// Clear existing meals
mysqli_query($conn, "DELETE FROM meals WHERE user_id='$user_id'");

// Restore meals
foreach($data["meals"] as $meal){
    $food_name = $meal["food_name"];
    $meal_type = $meal["meal_type"];
    $calories = $meal["calories"];
    $protein = $meal["protein"];
    $iron = $meal["iron"];
    $calcium = $meal["calcium"];
    $date = $meal["date"];

    mysqli_query($conn,
        "INSERT INTO meals(user_id, food_name, meal_type, calories, protein, iron, calcium, date)
        VALUES('$user_id', '$food_name', '$meal_type', '$calories', '$protein', '$iron', '$calcium', '$date')"
    );
}

echo "Backup Restored Successfully";
?>
