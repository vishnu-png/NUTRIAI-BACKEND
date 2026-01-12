<?php
include 'config.php';

// Turn off error reporting to JSON if possible, just text
error_reporting(E_ALL);
ini_set('display_errors', 1);

$cols = ['carbs', 'fat', 'fiber', 'sodium'];

foreach($cols as $col){
    try {
        mysqli_query($conn, "ALTER TABLE meals ADD COLUMN $col DOUBLE DEFAULT 0");
        echo "Added $col<br>";
    } catch (Throwable $e) { // Catch ALL errors including Fatal
        echo "Skipped $col (Error: " . $e->getMessage() . ")<br>";
    }
}
echo "Meals Table Update Complete.";
?>
