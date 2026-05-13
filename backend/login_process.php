<?php
session_start();
require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../login.php");
    exit();
}

//Get and sanitize input
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($email) || empty($password)) {
    header("Location: ../login.php?error=empty_fields");
    exit();
}

//Get user (WITH 2FA FIELD)
$stmt = $conn->prepare("
    SELECT id, email, password, role, status, twofa_enabled
    FROM users
    WHERE email = ?
");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

//Check user exists
if ($result->num_rows !== 1) {
    header("Location: ../login.php?error=user_not_found");
    exit();
}

$user = $result->fetch_assoc();

//Check account status
if ($user['status'] === 'pending') {
    header("Location: ../login.php?error=pending");
    exit();
}

if ($user['status'] === 'inactive') {
    header("Location: ../login.php?error=inactive");
    exit();
}

//Verify password
if (!password_verify($password, $user['password'])) {
    header("Location: ../login.php?error=wrong_password");
    exit();
}

if ((int)$user['force_password_change'] === 1) {

    // allow login session but redirect to password change page
    $_SESSION['temp_user_id'] = $user['id'];

    header("Location: ../change_password.php");
    exit();
}

//Success login flow
session_regenerate_id(true);

// CHECK 2FA
if ((int)$user['twofa_enabled'] === 1) {

    // TEMP SESSION ONLY (NOT FULL LOGIN YET)
    $_SESSION['temp_user_id'] = $user['id'];

    header("Location: ../verify-otp.php");
    exit();
}

//NO 2FA to FULL LOGIN
$_SESSION['user_id'] = $user['id'];
$_SESSION['user_email'] = $user['email'];
$_SESSION['role'] = $user['role'];

//Role redirect
if ($user['role'] === 'admin') {
    header("Location: ../admin/dashboard.php");
} else {
    header("Location: ../index.php");
}

exit();
