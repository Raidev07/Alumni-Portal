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

// Include status in query
$stmt = $conn->prepare("SELECT id, email, password, role, status FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Check if user exists
if ($result->num_rows === 1) {

    $user = $result->fetch_assoc();

    // Check account status FIRST
    if ($user['status'] === 'pending') {
        header("Location: ../login.php?error=pending");
        exit();
    }

    if ($user['status'] === 'inactive') {
        header("Location: ../login.php?error=inactive");
        exit();
    }

    // Verify password
    if (password_verify($password, $user['password'])) {

        // Secure session
        session_regenerate_id(true);

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['role'] = $user['role'];

        // Redirect by role
        if ($user['role'] === 'admin') {
            header("Location: ../admin/dashboard.php");
        } elseif ($user['role'] === 'alumni') {
            header("Location: ../index.php");
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