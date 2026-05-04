<?php
session_start();
require_once __DIR__ . "/../../backend/db.php";

if (!isset($_SESSION['user_id'])) {
    exit("unauthorized");
}

$uid = $_SESSION['user_id'];

/* optional: delete file sa folder */
$stmt = $conn->prepare("SELECT profile_picture FROM userprofile WHERE user_id = ?");
$stmt->bind_param("i", $uid);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

if (!empty($result['profile_picture'])) {
    $file = __DIR__ . "/../../uploads/profile/" . $result['profile_picture'];
    if (file_exists($file)) {
        unlink($file);
    }
}

/* set DB to NULL */
$stmt = $conn->prepare("UPDATE userprofile SET profile_picture = NULL WHERE user_id = ?");
$stmt->bind_param("i", $uid);

if ($stmt->execute()) {
    echo "success";
} else {
    echo "failed";
}   