<?php
session_start();
require_once "db.php";
require_once __DIR__ . '/../vendor/autoload.php';

use PragmaRX\Google2FA\Google2FA;

$google2fa = new Google2FA();

if (!isset($_SESSION['temp_user_id']) || !isset($_POST['otp'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['temp_user_id'];

/* GET FRESH USER DATA */
$stmt = $conn->prepare("SELECT id, email, role, twofa_secret FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

/* CLEAN OTP */
$otp = trim($_POST['otp']);

/* VALIDATE FORMAT */
if (!preg_match('/^\d{6}$/', $otp)) {
    header("Location: ../verify-otp.php?error=invalid");
    exit();
}

/* 🔥 FIX: TIME WINDOW TOLERANCE ADDED */
$valid = $google2fa->verifyKey(
    $user['twofa_secret'],
    $otp,
    2 // IMPORTANT FIX (prevents first-time invalid issue)
);

if ($valid) {

    session_regenerate_id(true);

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_email'] = $user['email'];
    $_SESSION['role'] = $user['role'];

    unset($_SESSION['temp_user_id']);

    if ($user['role'] === 'admin') {
        header("Location: ../admin/dashboard.php");
    } else {
        header("Location: ../index.php");
    }

    exit();
} else {
    header("Location: ../verify-otp.php?error=invalid");
    exit();
}
