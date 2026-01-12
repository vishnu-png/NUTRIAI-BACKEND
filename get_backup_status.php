<?php
require 'config.php';
header('Content-Type: application/json');

$user_id = $_GET['user_id'] ?? '';

if (empty($user_id)) {
    echo json_encode(["status" => "failed", "message" => "User ID required"]);
    exit();
}

// 1. Get Last Synced Time
$user_sql = "SELECT last_synced FROM users WHERE id = '$user_id'";
$res = $conn->query($user_sql);
$last_synced = null;
if ($res && $res->num_rows > 0) {
    $row = $res->fetch_assoc();
    $last_synced = $row['last_synced'];
}

// 2. Calculate Storage Usage (Approximate + Overhead)
// We add some "base" app data overhead (e.g. 2MB) + multiplier for DB indexing overhead
$base_overhead = 2.4 * 1024 * 1024; // 2.4 MB base
$size_bytes = $base_overhead;

// Meals (approx 500 bytes real + overhead)
$m_res = $conn->query("SELECT COUNT(*) as c FROM meals WHERE user_id='$user_id'");
if ($m_res) $size_bytes += ($m_res->fetch_assoc()['c'] * 500);

// BMI & Deficiency
$b_res = $conn->query("SELECT COUNT(*) as c FROM user_bmi_records WHERE user_id='$user_id'");
if ($b_res) $size_bytes += ($b_res->fetch_assoc()['c'] * 200);

$d_res = $conn->query("SELECT COUNT(*) as c FROM user_deficiency_reports WHERE user_id='$user_id'");
if ($d_res) $size_bytes += ($d_res->fetch_assoc()['c'] * 200);

// Profile Image (Mock)
$size_bytes += 500 * 1024; // +500KB for profile pic

// Format Size
$unit = "KB";
$size_display = round($size_bytes / 1024, 1);
if ($size_display > 1024) {
    $size_val_mb = round($size_display / 1024, 1);
    $size_display = $size_val_mb;
    $unit = "MB";
} else {
    $size_val_mb = $size_display / 1024; // for percent calc
}

// 1GB Limit
$limit_mb = 1024; 
$limit_display = "1 GB"; 

$usage_text = "$size_display $unit / $limit_display"; 

// Percent
$percent = min(100, ($size_bytes / ($limit_mb * 1024 * 1024)) * 100);

// Format Time
$time_display = "Never";
if ($last_synced) {
    $time_diff = time() - strtotime($last_synced);
    if ($time_diff < 60) $time_display = "Just now";
    elseif ($time_diff < 3600) $time_display = floor($time_diff / 60) . " minutes ago";
    elseif ($time_diff < 86400) $time_display = floor($time_diff / 3600) . " hours ago";
    else $time_display = date("M d, Y", strtotime($last_synced));
}

echo json_encode([
    "status" => "success",
    "backup_active" => true,
    "last_synced" => $time_display,
    "storage_usage_text" => $usage_text,
    "storage_percent" => min(100, ($size_bytes / (100 * 1024 * 1024)) * 100) // percent of 100MB
]);
?>
