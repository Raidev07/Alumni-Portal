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

$school = trim($_POST['school'] ?? '');
$degree = trim($_POST['degree'] ?? '');
$awards = trim($_POST['awards'] ?? '');
$start_year = $_POST['start_year'] ?? '';
$end_year = $_POST['end_year'] ?? '';

$stmt = $conn->prepare("
    UPDATE education
    SET
        school = ?,
        degree = ?,
        awards = ?,
        start_year = ?,
        end_year = ?
    WHERE edu_id = ? AND user_id = ?
");

$stmt->bind_param(
    "sssiiii",
    $school,
    $degree,
    $awards,
    $start_year,
    $end_year,
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