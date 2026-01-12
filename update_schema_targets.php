<?php
require_once 'config.php';

// Add target columns to users table
$alter_queries = [
    "ALTER TABLE users ADD COLUMN target_calories INT DEFAULT 2000",
    "ALTER TABLE users ADD COLUMN target_protein DECIMAL(5,2) DEFAULT 150.00",
    "ALTER TABLE users ADD COLUMN target_carbs DECIMAL(5,2) DEFAULT 250.00",
    "ALTER TABLE users ADD COLUMN target_fat DECIMAL(5,2) DEFAULT 70.00",
    "ALTER TABLE users ADD COLUMN diet_preference ENUM('veg', 'non-veg', 'keto', 'vegan') DEFAULT 'non-veg'" // Re-run safe
];

foreach ($alter_queries as $query) {
    try {
        if ($conn->query($query) === TRUE) {
            echo "Successfully executed: $query <br>";
        } else {
            // Ignore duplicate column errors
            if (strpos($conn->error, "Duplicate column name") !== false) {
                 echo "Column already exists (Skipped): $query <br>";
            } else {
                 echo "Error executing: $query - " . $conn->error . "<br>";
            }
        }
    } catch (Exception $e) {
        echo "Exception: " . $e->getMessage() . "<br>";
    }
}

echo "Schema update complete.";
?>
