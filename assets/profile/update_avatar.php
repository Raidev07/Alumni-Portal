<?php
session_start();
require_once __DIR__ . "/../../backend/db.php";

if (!isset($_SESSION['user_id'])) {
    exit("Unauthorized");
}

$uid = $_SESSION['user_id'];

if (!isset($_FILES['avatar'])) {
    exit("No file uploaded");
}

$file = $_FILES['avatar'];

//  GET OLD IMAGE
$stmt = $conn->prepare("SELECT profile_picture FROM userprofile WHERE user_id = ?");
$stmt->bind_param("i", $uid);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

$oldFile = $result['profile_picture'] ?? null;

// DELETE OLD FILE
if ($oldFile) {
    $oldPath = __DIR__ . "/../../uploads/profile/" . $oldFile;

    if (file_exists($oldPath)) {
        unlink($oldPath);
    }
}

// UPLOAD NEW FILE
$ext = pathinfo($file['name'], PATHINFO_EXTENSION);
$filename = "avatar_" . $uid . "_" . time() . "." . $ext;

$targetDir = __DIR__ . "/../../uploads/profile/";

if (!is_dir($targetDir)) {
    mkdir($targetDir, 0777, true);
}

$targetPath = $targetDir . $filename;

if (move_uploaded_file($file['tmp_name'], $targetPath)) {

    $stmt = $conn->prepare("UPDATE userprofile SET profile_picture = ? WHERE user_id = ?");
    $stmt->bind_param("si", $filename, $uid);
    $stmt->execute();

    echo "success";
} else {
    echo "upload_failed";
}