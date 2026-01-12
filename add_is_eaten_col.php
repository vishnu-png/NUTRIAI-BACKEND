<?php
require 'config.php';

// Add is_eaten column to meals table
$sql = "ALTER TABLE meals ADD COLUMN is_eaten TINYINT(1) DEFAULT 0";

try {
    if ($conn->query($sql) === TRUE) {
        echo "Column 'is_eaten' added successfully";
    } else {
        // Check if error is duplicate column
        if (strpos($conn->error, "Duplicate column name") !== false) {
             echo "Column 'is_eaten' already exists";
        } else {
             echo "Error updating schema: " . $conn->error;
        }
    }
} catch (Exception $e) {
    if (strpos($e->getMessage(), "Duplicate column name") !== false) {
         echo "Column 'is_eaten' already exists";
    } else {
         echo "exception: " . $e->getMessage();
    }
}

$conn->close();
?>
