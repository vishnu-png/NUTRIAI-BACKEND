<?php
include 'config.php';


if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo json_encode(["status" => "error", "message" => "Invalid Request Method"]);
    exit;
}

$user_id = $_POST['user_id'] ?? '';
$food_id = $_POST['food_id'] ?? '';
$meal_type = $_POST['meal_type'] ?? '';

if (empty($user_id) || empty($food_id) || empty($meal_type)) {
    echo json_encode(["status" => "error", "message" => "Missing Fields: user_id, food_id, or meal_type"]);
    exit;
}

// Fetch food details from database
$stmt = $conn->prepare("SELECT * FROM foods WHERE id = ?");
$stmt->bind_param("s", $food_id); // Use 's' for flexibility
$stmt->execute();
$result = $stmt->get_result();
$food = $result->fetch_assoc();
$stmt->close();

if (!$food) {
    echo json_encode(["status" => "error", "message" => "Food Not Found"]);
    exit;
}

// Extract nutrient values
$food_name = $food['food_name'];
$calories = $food['calories'];
$protein = $food['protein'];
$iron = $food['iron'];
$calcium = $food['calcium'];
$date = date("Y-m-d");

// Insert into meals table
$insert_stmt = $conn->prepare("INSERT INTO meals (user_id, meal_type, food_name, calories, protein, iron, calcium, date, is_eaten) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 0)");
$insert_stmt->bind_param("sssdddds", $user_id, $meal_type, $food_name, $calories, $protein, $iron, $calcium, $date);

if ($insert_stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Meal Added Automatically", "meal_id" => $conn->insert_id]);
} else {
    echo json_encode(["status" => "error", "message" => "Error Adding Meal: " . $conn->error]);
}
$insert_stmt->close();
$conn->close();

?>
