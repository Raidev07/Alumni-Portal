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
   HANDLE POST REQUESTS
===================== */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    /* =====================
       CHANGE PASSWORD
    ===================== */
    if (isset($_POST['change_password'])) {

        $current = $_POST['current_password'];
        $new = $_POST['new_password'];
        $confirm = $_POST['confirm_password'];

        // Password rules
        $hasUpper = preg_match('/[A-Z]/', $new);
        $hasLower = preg_match('/[a-z]/', $new);
        $hasNumber = preg_match('/[0-9]/', $new);
        $hasSpecial = preg_match('/[!@#$%^&*(),.?":{}|<>]/', $new);
        $hasNoSpaces = !preg_match('/\s/', $new);
        $validLength = strlen($new) >= 8 && strlen($new) <= 20;

        // Validate password
        if (
            !$validLength ||
            !$hasUpper ||
            !$hasLower ||
            !$hasNumber ||
            !$hasSpecial ||
            !$hasNoSpaces
        ) {
            $_SESSION['message'] =
                "Password must be 8-20 characters and include uppercase, lowercase, number, special character, and no spaces.";
            header("Location: security.php");
            exit();
        }

        // Confirm password match
        if ($new !== $confirm) {
            $_SESSION['message'] = "Password confirmation does not match";
            header("Location: security.php");
            exit();
        }

        $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $dbUser = $stmt->get_result()->fetch_assoc();

        if (!$dbUser || !password_verify($current, $dbUser['password'])) {
            $_SESSION['message'] = "Incorrect current password";
            header("Location: security.php");
            exit();
        }

        // Prevent using the same password
        if (password_verify($new, $dbUser['password'])) {
            $_SESSION['message'] = "New password cannot be the same as your current password";
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
       ENABLE 2FA + GENERATE BACKUP CODES (FIXED)
    ===================== */
    if (isset($_POST['enable_2fa'])) {

        $secret = $google2fa->generateSecretKey();

        $stmt = $conn->prepare("UPDATE users SET twofa_secret = ?, twofa_enabled = 0 WHERE id = ?");
        $stmt->bind_param("si", $secret, $user_id);
        $stmt->execute();

        // delete old backup codes
        $stmt = $conn->prepare("DELETE FROM backup_codes WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();

        $generated_codes = [];

        // generate new backup codes
        for ($i = 0; $i < 5; $i++) {

            $code = strtoupper(bin2hex(random_bytes(4)));

            $stmt = $conn->prepare("
                INSERT INTO backup_codes (user_id, code, used)
                VALUES (?, ?, 0)
            ");
            $stmt->bind_param("is", $user_id, $code);
            $stmt->execute();

            $generated_codes[] = $code;
        }

        // STORE FOR DISPLAY (IMPORTANT FIX)
        $_SESSION['backup_codes'] = $generated_codes;

        $_SESSION['message'] = "2FA enabled. Scan QR and save backup codes.";
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

        if (!$user || !$user['twofa_secret']) {
            $_SESSION['message'] = "2FA not initialized";
            header("Location: security.php");
            exit();
        }

        $valid = $google2fa->verifyKey($user['twofa_secret'], $otp, 2);

        if ($valid) {

            $stmt = $conn->prepare("UPDATE users SET twofa_enabled = 1 WHERE id = ?");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();

            $_SESSION['message'] = "2FA Enabled successfully";
        } else {
            $_SESSION['message'] = "Invalid OTP";
        }

        header("Location: security.php");
        exit();
    }

    /* =====================
       DISABLE 2FA
    ===================== */
    if (isset($_POST['disable_2fa'])) {

        $stmt = $conn->prepare("
            UPDATE users 
            SET twofa_enabled = 0, twofa_secret = NULL 
            WHERE id = ?
        ");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();

        $_SESSION['message'] = "2FA Disabled";
        header("Location: security.php");
        exit();
    }
}

/* =====================
   LOAD USER DATA
===================== */

$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

$message = $_SESSION['message'] ?? '';
unset($_SESSION['message']);

/* =====================
   GET BACKUP CODES (FIX)
===================== */
$backup_codes = $_SESSION['backup_codes'] ?? [];
unset($_SESSION['backup_codes']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Security Settings | Alumni Portal</title>
    <link rel="icon" href="assets/image/alumni_plp_newicon.png">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/alumni_homepage.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .security-section {
            padding: 4rem 0 5rem;
            background: #f0f5f2;
        }

        .security-container {
            max-width: 920px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        .security-card {
            background: #ffffff;
            border: 1px solid rgba(0, 0, 0, 0.08);
            border-radius: 24px;
            box-shadow: 0 26px 75px rgba(10, 48, 21, 0.08);
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .security-card-content {
            padding: 2rem;
        }

        .security-card-content h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: #0f172a;
        }

        .security-card-content p {
            color: #475569;
            line-height: 1.8;
        }

        .security-form {
            display: grid;
            gap: 1.25rem;
            margin-top: 1rem;
        }

        .form-group {
            display: grid;
            gap: 0.5rem;
        }

        .form-group label {
            font-size: 0.95rem;
            color: #334155;
            font-weight: 600;
        }

        .form-group input {
            width: 100%;
            border: 1px solid #d9e8e3;
            border-radius: 14px;
            padding: 1rem 1rem;
            background: #f8faf8;
            color: #0f172a;
            font-size: 0.95rem;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .form-group input:focus {
            outline: none;
            border-color: #006e14;
            box-shadow: 0 0 0 4px rgba(0, 110, 20, 0.12);
            background: #ffffff;
        }

        .password-box {
            position: relative;
        }

        .password-box input {
            padding-right: 3.2rem;
        }

        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #4b5563;
            font-size: 0.95rem;
            user-select: none;
        }

        .security-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            justify-content: flex-end;
            margin-top: 0.5rem;
        }

        .security-actions .btn {
            background: #ffffff;
            color: #006e14;
            border: 1px solid #006e14;
            padding: 0.65rem 1.25rem;
            border-radius: 5px;
            font-weight: 600;
            transition: background 0.2s ease, color 0.2s ease, transform 0.2s ease;
        }

        .security-actions .btn:hover {
            background: #006e14;
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        }

        .security-qr {
            display: grid;
            gap: 1.25rem;
            margin: 1.25rem 0 1rem;
            align-items: center;
            grid-template-columns: minmax(220px, 320px) minmax(0, 1fr);
        }

        .security-qr img {
            width: 100%;
            border-radius: 18px;
            border: 1px solid #d9e8e3;
            background: #ffffff;
        }

        .security-qr-key {
            padding: 1rem 1.15rem;
            background: #f5fbf5;
            border: 1px dashed #bde3bb;
            border-radius: 14px;
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
            color: #0f172a;
            word-break: break-word;
            font-size: 0.95rem;
        }

        .message {
            background: #e7f3ff;
            color: #0b2f61;
            border-left: 5px solid #007bff;
            padding: 1rem 1.2rem;
            margin-bottom: 1.75rem;
            border-radius: 0.85rem;
        }

        .section-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .section-header .subtitle {
            color: #229e00;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            font-size: 0.78rem;
            margin-bottom: 0.75rem;
            display: inline-block;
        }

        .section-header h2 {
            font-size: clamp(2rem, 2.5vw, 2.75rem);
            margin-bottom: 0.75rem;
            color: #0f172a;
        }

        .section-header p {
            color: #475569;
            max-width: 680px;
            margin: 0 auto;
            line-height: 1.8;
        }

        /* ── PROFILE ICON ─────────────────────────────────────────────── */
        .profile-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #f0f5f2;
            border: 1.5px solid #a8d5b0;
            color: #006e14;
            transition: all 0.25s;
            flex-shrink: 0;
            text-decoration: none;
            font-size: 1rem;
        }

        .profile-icon:hover,
        .profile-icon.active {
            background: #006e14;
            border-color: #006e14;
            color: #fff;
        }

        .hamburger-wrapper {
            position: relative;
            flex-shrink: 0;
        }

        .hamburger-btn {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: 5px;
            width: 38px;
            height: 38px;
            border-radius: 8px;
            background: #ffffff;
            border: 1.5px solid #a8d5b0;
            cursor: pointer;
            padding: 0;
            transition: all 0.25s;
        }

        .hamburger-btn span {
            display: block;
            width: 18px;
            height: 2px;
            background: #006e14;
            border-radius: 2px;
            transition: all 0.3s ease;
            transform-origin: center;
        }

        .hamburger-btn:hover {
            background: #006e14;
            border-color: #006e14;
        }

        .hamburger-btn:hover span {
            background: #fff;
        }

        .hamburger-btn.open span:nth-child(1) {
            transform: translateY(7px) rotate(45deg);
        }

        .hamburger-btn.open span:nth-child(2) {
            opacity: 0;
            transform: scaleX(0);
        }

        .hamburger-btn.open span:nth-child(3) {
            transform: translateY(-7px) rotate(-45deg);
        }

        .hamburger-dropdown {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            width: 215px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 28px rgba(0, 0, 0, 0.12);
            border: 1px solid #e8ede9;
            overflow: hidden;
            opacity: 0;
            transform: translateY(-8px) scale(0.97);
            pointer-events: none;
            transition: opacity 0.22s ease, transform 0.22s ease;
            z-index: 2000;
        }

        .hamburger-dropdown.show {
            opacity: 1;
            transform: translateY(0) scale(1);
            pointer-events: all;
        }

        .hamburger-dropdown ul {
            list-style: none;
            margin: 0;
            padding: 6px 0;
        }

        .hamburger-dropdown ul li a {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.65rem 1.1rem;
            font-size: 0.9rem;
            font-weight: 500;
            color: #0f172a;
            text-decoration: none;
            transition: background 0.18s, color 0.18s;
        }

        .hamburger-dropdown ul li a i {
            width: 17px;
            text-align: center;
            color: #006e14;
            font-size: 0.95rem;
            flex-shrink: 0;
            transition: color 0.18s;
        }

        .hamburger-dropdown ul li a:hover {
            background: #f0f9f1;
            color: #006e14;
        }

        .dropdown-divider-top {
            border-top: 1px solid #e8ede9;
            margin-top: 6px;
            padding-top: 6px;
        }

        .dropdown-divider-top a {
            color: #dc2626 !important;
        }

        .dropdown-divider-top a i {
            color: #dc2626 !important;
        }

        .dropdown-divider-top a:hover {
            background: #fff5f5 !important;
            color: #b91c1c !important;
        }

        @media (max-width: 768px) {
            .security-qr {
                grid-template-columns: 1fr;
            }
        }

        #requirements,
        #confirm-requirements {
            margin-top: 12px;
            padding-left: 0;
        }

        #requirements li,
        #confirm-requirements li {
            list-style: none;
            color: #ef4444;
            font-size: 0.82rem;
            line-height: 1.5;
            display: flex;
            align-items: center;
            margin-bottom: 6px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        #requirements li.met,
        #confirm-requirements li.met {
            color: #16a34a;
        }

        #requirements li::before,
        #confirm-requirements li::before {
            content: "X";
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 16px;
            height: 16px;
            margin-right: 10px;
            font-size: 10px;
            border-radius: 50%;
            flex-shrink: 0;
            background-color: #fee2e2;
            color: #ef4444;
            border: 1px solid #fecaca;
            transition: all 0.3s ease;
        }

        #requirements li.met::before,
        #confirm-requirements li.met::before {
            content: "✓";
            background-color: #dcfce7;
            color: #16a34a;
            border: 1px solid #bbf7d0;
        }

        .input-error {
            border: 1px solid #ef4444 !important;
            background: #fff5f5 !important;
        }
    </style>
</head>

<body>
    <?php include('includes/navbarhome.php'); ?>

    <section class="section security-section">
        <div class="security-container">

            <div class="section-header">
                <span class="subtitle">Account Security</span>
                <h2>Security Settings</h2>
                <p>Manage your password and two-factor authentication with the same polished style used across the
                    Alumni Portal.</p>
            </div>

            <?php if ($message): ?>
                <div class="message"><?= htmlspecialchars($message) ?></div>
            <?php endif; ?>

            <div class="security-card">
                <div class="security-card-content">
                    <h3>Change Password</h3>
                    <form method="POST" class="security-form">
                        <div class="form-group">
                            <label for="current_password">Current Password</label>
                            <div class="password-box">
                                <input type="password" id="current_password" name="current_password"
                                    placeholder="Current Password" autocomplete="current-password" required>
                                <span class="password-toggle" onclick="togglePassword('current_password')">Show</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="new_password">New Password</label>

                            <div class="password-box">
                                <input type="password" id="new_password" name="new_password" placeholder="New Password"
                                    autocomplete="new-password" required oninput="validatePassword()">

                                <span class="password-toggle" onclick="togglePassword('new_password')">
                                    Show
                                </span>
                            </div>

                            <ul id="requirements">
                                <li id="req-length">At least 8 and max 20 characters</li>
                                <li id="req-upper">At least one uppercase letter</li>
                                <li id="req-lower">At least one lowercase letter</li>
                                <li id="req-number">At least one number</li>
                                <li id="req-special">At least one special character (!@#$...)</li>
                                <li id="req-space">No spaces</li>
                            </ul>
                        </div>

                        <div class="form-group">
                            <label for="confirm_password">Confirm Password</label>

                            <div class="password-box">
                                <input type="password" id="confirm_password" name="confirm_password"
                                    placeholder="Confirm Password" autocomplete="new-password" required
                                    oninput="validateConfirm()">

                                <span class="password-toggle" onclick="togglePassword('confirm_password')">
                                    Show
                                </span>
                            </div>

                            <ul id="confirm-requirements">
                                <li id="req-match">Passwords must match</li>
                            </ul>
                        </div>

                        <div class="security-actions">
                            <button type="submit" name="change_password" class="btn">Change Password</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="security-card">
                <div class="security-card-content">
                    <h3>Two-Factor Authentication</h3>
                    <?php if (empty($user['twofa_secret'])): ?>
                        <p>Enable an extra layer of account protection by setting up two-factor authentication.</p>
                        <form method="POST" class="security-actions">
                            <button type="submit" name="enable_2fa" class="btn">Enable 2FA</button>
                        </form>
                    <?php else: ?>
                        <?php
                        $qr = $google2fa->getQRCodeUrl(
                            'Alumni Portal',
                            $user['email'],
                            $user['twofa_secret']
                        );
                        ?>
                        <div class="security-qr">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=240x240&data=<?= urlencode($qr) ?>"
                                alt="2FA QR code">
                            <div>
                                <p>Scan this QR code with your authenticator app, or enter the manual key below.</p>
                                <div class="security-qr-key"><?= htmlspecialchars($user['twofa_secret']) ?></div>
                            </div>
                        </div>
                        <?php if (empty($user['twofa_enabled'])): ?>
                            <form method="POST" class="security-form">
                                <div class="form-group">
                                    <label for="otp">Authenticator Code</label>
                                    <input type="text" id="otp" name="otp" placeholder="Enter OTP" required>
                                </div>
                                <div class="security-actions">
                                    <button type="submit" name="confirm_2fa" class="btn">Confirm Enable</button>
                                </div>
                            </form>
                        <?php else: ?>
                            <p>Your account is currently protected with 2FA.</p>
                            <form method="POST" class="security-actions">
                                <button type="submit" name="disable_2fa" class="btn">Disable 2FA</button>
                            </form>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>

            <?php if (!empty($backup_codes)): ?>
                <div class="security-card">
                    <div class="security-card-content">
                        <h3>Your Backup Codes</h3>
                        <p>Save these codes somewhere safe. Each code can only be used once.</p>

                        <div class="security-qr-key">
                            <?php foreach ($backup_codes as $code): ?>
                                <div><?= htmlspecialchars($code) ?></div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <?php include('includes/logoutmodal.php'); ?>
    <?php include('includes/footer.php'); ?>

    <script src="assets/js/alumni_homepage.js"></script>
    <script>
        function togglePassword(id) {
            const input = document.getElementById(id);
            input.type = input.type === 'password' ? 'text' : 'password';
        }

        function validatePassword() {
            var pass = document.getElementById("new_password").value;

            var rules = {
                "req-length": pass.length >= 8 && pass.length <= 20,
                "req-upper": /[A-Z]/.test(pass),
                "req-lower": /[a-z]/.test(pass),
                "req-number": /[0-9]/.test(pass),
                "req-special": /[!@#$%^&*(),.?":{}|<>]/.test(pass),
                "req-space": !/\s/.test(pass),
            };

            for (var key in rules) {
                var el = document.getElementById(key);

                if (el) {
                    el.classList.toggle("met", rules[key]);
                }
            }

            var allMet = Object.values(rules).every(Boolean);

            document
                .getElementById("new_password")
                .classList.toggle("input-error", !allMet && pass.length > 0);

            validateConfirm();
        }

        function validateConfirm() {
            var pass = document.getElementById("new_password").value;

            var confirm = document.getElementById("confirm_password").value;

            var match = confirm.length > 0 && pass === confirm;

            var el = document.getElementById("req-match");

            if (el) {
                el.classList.toggle("met", match);
            }

            document
                .getElementById("confirm_password")
                .classList.toggle("input-error", !match && confirm.length > 0);
        }
    </script>
</body>

</html>