<?php
include 'config.php';

// Add last_synced column to users table
$sql = "ALTER TABLE users ADD COLUMN IF NOT EXISTS last_synced DATETIME DEFAULT CURRENT_TIMESTAMP";

if ($conn->query($sql) === TRUE) {
    echo "Table users updated successfully (added last_synced)";
} else {
    echo "Error updating table: " . $conn->error;
}

$conn->close();
?>
