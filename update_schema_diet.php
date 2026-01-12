<?php
require 'config.php';

// Add diet_preference to users
$sqlUsers = "ALTER TABLE users ADD COLUMN diet_preference ENUM('veg', 'non-veg', 'keto', 'vegan') DEFAULT 'veg'";
try {
    $conn->query($sqlUsers);
    echo "Added diet_preference to users (or already exists)\n";
} catch (Exception $e) { echo "Users Error: " . $e->getMessage() . "\n"; }

// Add category to foods
$sqlFoods = "ALTER TABLE foods ADD COLUMN category ENUM('veg', 'non-veg', 'keto', 'vegan') DEFAULT 'veg'";
try {
    $conn->query($sqlFoods);
    echo "Added category to foods (or already exists)\n";
} catch (Exception $e) { echo "Foods Error: " . $e->getMessage() . "\n"; }

// Seed some categories if foods exist (Simple heuristic or random for demo)
// In a real app, this would be manual or intelligent. Here we'll randomise for demo purposes if NULL
$conn->query("UPDATE foods SET category = 'non-veg' WHERE food_name LIKE '%chicken%' OR food_name LIKE '%egg%' OR food_name LIKE '%fish%' OR food_name LIKE '%steak%'");
$conn->query("UPDATE foods SET category = 'veg' WHERE category = 'veg' AND (food_name LIKE '%salad%' OR food_name LIKE '%rice%' OR food_name LIKE '%dosa%')");

echo "Schema updated and basic categorization applied.\n";
$conn->close();
?>
