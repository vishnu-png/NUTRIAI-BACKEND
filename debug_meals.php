<?php
include 'config.php';
$result = mysqli_query($conn, "SHOW COLUMNS FROM meals");
while ($row = mysqli_fetch_assoc($result)) {
    echo $row['Field'] . ",";
}
?>
