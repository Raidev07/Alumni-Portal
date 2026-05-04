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

$school = trim($_POST['school'] ?? '');
$degree = trim($_POST['degree'] ?? '');
$awards = trim($_POST['awards'] ?? '');
$start_year = $_POST['start_year'] ?? '';
$end_year = $_POST['end_year'] ?? '';

if ($school === '' || $degree === '') {
    echo json_encode([
        "status" => "error",
        "message" => "School and degree required"
    ]);
    exit();
}

$stmt = $conn->prepare("
    INSERT INTO education
    (user_id, school, degree, awards, start_year, end_year)
    VALUES (?, ?, ?, ?, ?, ?)
");

$stmt->bind_param(
    "isssii",
    $user_id,
    $school,
    $degree,
    $awards,
    $start_year,
    $end_year
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