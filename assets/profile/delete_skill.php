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

$stmt = $conn->prepare("
    DELETE FROM skills
    WHERE skill_id = ? AND user_id = ?
");

$stmt->bind_param("ii", $id, $user_id);

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