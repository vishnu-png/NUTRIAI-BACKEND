<?php
require 'config.php';
$res = $conn->query("SHOW TABLES LIKE '%health%'");
if ($res->num_rows > 0) {
    echo "Found tables:\n";
    while($row = $res->fetch_row()) {
        echo "- " . $row[0] . "\n";
        $desc = $conn->query("DESCRIBE " . $row[0]);
        while($d = $desc->fetch_assoc()) {
            echo "  " . $d['Field'] . " (" . $d['Type'] . ")\n";
        }
    }
} else {
    echo "No health tables found via generic search.\n";
}

$res = $conn->query("SHOW TABLES LIKE '%bmi%'");
if ($res->num_rows > 0) {
    echo "Found BMI tables:\n";
    while($row = $res->fetch_row()) {
        echo "- " . $row[0] . "\n";
    }
}
?>
