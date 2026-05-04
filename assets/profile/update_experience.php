<?php
session_start();
require_once "../../backend/db.php";

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        "status" => "error"
    ]);
    exit();
}

$user_id = $_SESSION['user_id'];

$id = $_POST['id'] ?? 0;

$title = trim($_POST['title'] ?? '');
$company = trim($_POST['company'] ?? '');
$location = trim($_POST['location'] ?? '');
$start_date = $_POST['start_date'] ?? '';
$end_date = $_POST['end_date'] ?? '';
$description = trim($_POST['description'] ?? '');

$stmt = $conn->prepare("
    UPDATE experience
    SET
        title = ?,
        company = ?,
        location = ?,
        start_date = ?,
        end_date = ?,
        description = ?
    WHERE exp_id = ? AND user_id = ?
");

$stmt->bind_param(
    "ssssssii",
    $title,
    $company,
    $location,
    $start_date,
    $end_date,
    $description,
    $id,
    $user_id
);

if ($stmt->execute()) {

    echo json_encode([
        "status" => "success"
    ]);

} else {

    echo json_encode([
        "status" => "error",
        "message" => $stmt->error
    ]);
}