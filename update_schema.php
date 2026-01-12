<?php
include 'config.php';

$cols = ['carbs', 'fat', 'fiber', 'sodium'];

foreach($cols as $col){
    try {
        $check = mysqli_query($conn, "SHOW COLUMNS FROM meals LIKE '$col'");
        if(mysqli_num_rows($check) == 0){
             if(mysqli_query($conn, "ALTER TABLE meals ADD COLUMN $col DOUBLE DEFAULT 0")){
                 echo "Added $col to meals<br>";
             } else {
                 echo "Failed to add $col: " . mysqli_error($conn) . "<br>";
             }
        } else {
            echo "$col already exists in meals<br>";
        }
    } catch (Exception $e) {
        echo "Exception for $col: " . $e->getMessage() . "<br>";
    }
}
?>
