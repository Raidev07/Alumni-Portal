<?php
session_start();
require_once "../../backend/db.php";

header("Content-Type: application/json");

if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Unauthorized"
    ]);
    exit();
}

$user_id = $_SESSION['user_id'];

$first_name  = trim($_POST['first_name'] ?? '');
$middle_name = trim($_POST['middle_name'] ?? '');
$last_name   = trim($_POST['last_name'] ?? '');
$suffix      = trim($_POST['suffix'] ?? '');
$headline    = trim($_POST['headline'] ?? '');
$address     = trim($_POST['address'] ?? '');
$email       = trim($_POST['email'] ?? '');

if (empty($first_name) || empty($last_name) || empty($email)) {
    echo json_encode([
        "status" => "error",
        "message" => "Required fields are missing"
    ]);
    exit();
}

/* UPDATE USERS EMAIL */
$stmt = $conn->prepare("
    UPDATE users
    SET email = ?
    WHERE id = ?
");

$stmt->bind_param("si", $email, $user_id);

if (!$stmt->execute()) {
    echo json_encode([
        "status" => "error",
        "message" => "Failed to update email"
    ]);
    exit();
}

/* CHECK PROFILE */
$check = $conn->prepare("
    SELECT user_id
    FROM userprofile
    WHERE user_id = ?
");

$check->bind_param("i", $user_id);
$check->execute();
$result = $check->get_result();

/* UPDATE OR INSERT PROFILE */
if ($result->num_rows > 0) {

    $stmt = $conn->prepare("
        UPDATE userprofile
        SET
            first_name = ?,
            middle_name = ?,
            last_name = ?,
            suffix = ?,
            address = ?
        WHERE user_id = ?
    ");

    $stmt->bind_param(
        "sssssi",
        $first_name,
        $middle_name,
        $last_name,
        $suffix,
        $address,
        $user_id
    );

} else {

    $stmt = $conn->prepare("
        INSERT INTO userprofile (
            user_id,
            first_name,
            middle_name,
            last_name,
            suffix,
            address
        )
        VALUES (?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "isssss",
        $user_id,
        $first_name,
        $middle_name,
        $last_name,
        $suffix,
        $address
    );
}

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
?>