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

$skill = trim($_POST['skill'] ?? '');

if ($skill === '') {
    echo json_encode([
        "status" => "error",
        "message" => "Skill required"
    ]);
    exit();
}

$stmt = $conn->prepare("
    INSERT INTO skills
    (user_id, skill_name)
    VALUES (?, ?)
");

$stmt->bind_param("is", $user_id, $skill);

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