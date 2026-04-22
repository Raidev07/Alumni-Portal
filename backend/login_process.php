<?php
session_start();
require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../login.php");
    exit();
}

// 1. Get and sanitize input
$email = trim($_POST['email']);
$password = trim($_POST['password']);

if (empty($email) || empty($password)) {
    die("Please fill in all fields.");
}

// Use prepared statement (prevents SQL injection)
$stmt = $conn->prepare("SELECT id, email, password, role FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Check user exists
if ($result->num_rows === 1) {

    $user = $result->fetch_assoc();

    // Verify password (secure hashing)
    if (password_verify($password, $user['password'])) {

        // Secure session setup
        session_regenerate_id(true);

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['role'] = $user['role'];

        // Role-based redirect
        if ($user['role'] === 'admin') {
            header("Location: ../admin/dashboard.php");
        } elseif ($user['role'] === 'alumni') {
            header("Location: ../alumni/home.php");
        } else {
            header("Location: ../student/home.php");
        }

        exit();

    } else {
        // Wrong password
        header("Location: ../login.php?error=wrong_password");
        exit();
    }

} else {
    // User not found
    header("Location: ../login.php?error=user_not_found");
    exit();
}
?>