<?php
session_start();
require_once "../../backend/db.php";

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Not logged in"
    ]);
    exit();
}

$user_id = $_SESSION['user_id'];

$title = trim($_POST['title'] ?? '');
$company = trim($_POST['company'] ?? '');
$location = trim($_POST['location'] ?? '');
$start_date = $_POST['start_date'] ?? '';
$end_date = $_POST['end_date'] ?? '';
$description = trim($_POST['description'] ?? '');

if ($title === '' || $company === '') {
    echo json_encode([
        "status" => "error",
        "message" => "Title and company required"
    ]);
    exit();
}

$stmt = $conn->prepare("
    INSERT INTO experience
    (user_id, title, company, location, start_date, end_date, description)
    VALUES (?, ?, ?, ?, ?, ?, ?)
");

$stmt->bind_param(
    "issssss",
    $user_id,
    $title,
    $company,
    $location,
    $start_date,
    $end_date,
    $description
);

if ($stmt->execute()) {

    echo json_encode([
        "status" => "success",
        "id" => $stmt->insert_id
    ]);

} else {

    echo json_encode([
        "status" => "error",
        "message" => $stmt->error
    ]);
}