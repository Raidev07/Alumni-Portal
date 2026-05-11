<?php
session_start();
include("backend/db.php");
require_once __DIR__ . '/vendor/autoload.php';

use PragmaRX\Google2FA\Google2FA;

$google2fa = new Google2FA();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* =====================
   HANDLE POST REQUESTS FIRST
===================== */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    /* =====================
       CHANGE PASSWORD
    ===================== */
    if (isset($_POST['change_password'])) {

        $current = $_POST['current_password'];
        $new = $_POST['new_password'];
        $confirm = $_POST['confirm_password'];

        if ($new !== $confirm) {
            $_SESSION['message'] = "Password confirmation does not match";
            header("Location: security.php");
            exit();
        }

        $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $dbUser = $stmt->get_result()->fetch_assoc();

        if (!password_verify($current, $dbUser['password'])) {
            $_SESSION['message'] = "Incorrect current password";
            header("Location: security.php");
            exit();
        }

        $hashed = password_hash($new, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->bind_param("si", $hashed, $user_id);
        $stmt->execute();

        $_SESSION['message'] = "Password updated successfully";
        header("Location: security.php");
        exit();
    }

    /* =====================
       ENABLE 2FA
    ===================== */
    if (isset($_POST['enable_2fa'])) {

        $secret = $google2fa->generateSecretKey();

        $stmt = $conn->prepare("UPDATE users SET twofa_secret = ? WHERE id = ?");
        $stmt->bind_param("si", $secret, $user_id);
        $stmt->execute();

        $_SESSION['message'] = "2FA enabled. Scan QR code.";
        header("Location: security.php");
        exit();
    }

    /* =====================
       CONFIRM 2FA
    ===================== */
    if (isset($_POST['confirm_2fa'])) {

        $otp = $_POST['otp'];

        $stmt = $conn->prepare("SELECT twofa_secret FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();

        $valid = $google2fa->verifyKey($user['twofa_secret'], $otp, 2);

        if ($valid) {

            $stmt = $conn->prepare("UPDATE users SET twofa_enabled = 1 WHERE id = ?");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();

            $_SESSION['message'] = "2FA Enabled successfully";
        } else {
            $_SESSION['message'] = "Invalid OTP. Please try again.";
        }

        header("Location: security.php");
        exit();
    }

    /* =====================
       DISABLE 2FA
    ===================== */
    if (isset($_POST['disable_2fa'])) {

        $stmt = $conn->prepare("UPDATE users SET twofa_enabled = 0, twofa_secret = NULL WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();

        $_SESSION['message'] = "2FA Disabled";
        header("Location: security.php");
        exit();
    }
}

/* =====================
   LOAD USER FRESH
===================== */

$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

$message = $_SESSION['message'] ?? '';
unset($_SESSION['message']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Security Settings</title>

    <style>
        body {
            font-family: Arial;
            background: #f4f6f9;
            padding: 20px;
        }

        .container {
            max-width: 700px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        button {
            background: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 6px;
            cursor: pointer;
        }

        button:hover {
            background: #0056b3;
        }

        .back-btn {
            display: inline-block;
            margin-bottom: 15px;
            padding: 8px 12px;
            background: #6c757d;
            color: white;
            text-decoration: none;
            border-radius: 6px;
        }

        .back-btn:hover {
            background: #5a6268;
        }

        .message {
            background: #e7f3ff;
            padding: 10px;
            border-left: 5px solid #007bff;
            margin-bottom: 15px;
        }

        .password-box {
            position: relative;
            display: flex;
            align-items: center;
        }

        .password-box input {
            width: 100%;
            padding: 10px;
            padding-right: 40px;
        }

        .password-box span {
            position: absolute;
            right: 10px;
            cursor: pointer;
            user-select: none;
            font-size: 14px;
        }
    </style>
</head>

<body>

    <div class="container">

        <!-- 🔙 TEMP BACK BUTTON -->
        <a href="index.php" class="back-btn">← Back</a>

        <h2>Security Settings</h2>

        <?php if ($message): ?>
            <div class="message"><?= $message ?></div>
        <?php endif; ?>

        <hr>

        <h3>Change Password</h3>

        <form method="POST">

            <div class="password-box">
                <input type="password" id="current_password" name="current_password" placeholder="Current Password" required>
                <span onclick="togglePassword('current_password')">👁</span>
            </div>

            <br>

            <div class="password-box">
                <input type="password" id="new_password" name="new_password" placeholder="New Password" required>
                <span onclick="togglePassword('new_password')">👁</span>
            </div>

            <br>

            <div class="password-box">
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>
                <span onclick="togglePassword('confirm_password')">👁</span>
            </div>

            <br>

            <button name="change_password">Change Password</button>
        </form>

        <hr>

        <h3>Two-Factor Authentication</h3>

        <?php if (empty($user['twofa_secret'])): ?>

            <form method="POST">
                <button name="enable_2fa">Enable 2FA</button>
            </form>

        <?php else: ?>

            <?php
            $qr = $google2fa->getQRCodeUrl(
                'Alumni Portal',
                $user['email'],
                $user['twofa_secret']
            );
            ?>

            <p>Scan QR Code:</p>
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=<?= urlencode($qr) ?>">

            <p><b>Manual Key:</b> <?= $user['twofa_secret'] ?></p>

            <?php if (empty($user['twofa_enabled'])): ?>

                <form method="POST">
                    <input type="text" name="otp" placeholder="Enter OTP" required>
                    <button name="confirm_2fa">Confirm Enable</button>
                </form>

            <?php else: ?>

                <p>2FA is ENABLED</p>

                <form method="POST">
                    <button name="disable_2fa">Disable 2FA</button>
                </form>

            <?php endif; ?>

        <?php endif; ?>

    </div>

    <script>
        function togglePassword(id) {
            const input = document.getElementById(id);

            if (input.type === "password") {
                input.type = "text";
            } else {
                input.type = "password";
            }
        }
    </script>

</body>

</html>