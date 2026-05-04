<?php
session_start();
require_once "../../backend/db.php";

if (!isset($_SESSION['user_id'])) {
    exit("Unauthorized");
}

$uid = $_SESSION['user_id'];
$about = $_POST['about'] ?? '';

// check if row exists
$check = $conn->prepare("SELECT user_id FROM userprofile WHERE user_id = ?");
$check->bind_param("i", $uid);
$check->execute();
$exists = $check->get_result()->num_rows > 0;

if ($exists) {
    $stmt = $conn->prepare("UPDATE userprofile SET about = ? WHERE user_id = ?");
    $stmt->bind_param("si", $about, $uid);
} else {
    $stmt = $conn->prepare("INSERT INTO userprofile (user_id, about) VALUES (?, ?)");
    $stmt->bind_param("is", $uid, $about);
}

$stmt->execute();

echo "success";