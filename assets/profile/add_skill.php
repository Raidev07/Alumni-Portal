<?php
session_start();
require_once "../../backend/db.php";
header("Content-Type: application/json");

if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        "status" => "error"
    ]);
    exit();
}

$user_id = $_SESSION['user_id'];

$skill = trim($_POST['skill'] ?? '');
$level = trim($_POST['level'] ?? '');

if (empty($skill) || empty($level)) {
    echo json_encode([
        "status" => "error",
        "message" => "All fields required"
    ]);
    exit();
}

$stmt = $conn->prepare("
    INSERT INTO skills (
        user_id,
        skill_name,
        skill_level
    )
    VALUES (?, ?, ?)
");

$stmt->bind_param(
    "iss",
    $user_id,
    $skill,
    $level
);

if ($stmt->execute()) {

    echo json_encode([
        "status" => "success",
        "id" => $conn->insert_id
    ]);

} else {

    echo json_encode([
        "status" => "error",
        "message" => $stmt->error
    ]);
}
?>