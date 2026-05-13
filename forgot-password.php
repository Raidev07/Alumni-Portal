<?php
session_start();
include("backend/db.php");

$message = "";

// back to login
if (isset($_POST['reset_all'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

// step control
$step = $_SESSION['step'] ?? "email";

// handle req
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $action = $_POST['action'] ?? '';

// step 1check email
    if ($action === 'email') {

        $email = trim($_POST['email']);

        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {

            $message = "Email not found.";
            $_SESSION['step'] = "email";
        } else {

            $user = $result->fetch_assoc();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $email;

            // check pending request immediately
            $stmt = $conn->prepare("
                SELECT id FROM recovery_requests 
                WHERE user_id = ? AND status = 'pending'
            ");
            $stmt->bind_param("i", $user['id']);
            $stmt->execute();

            $hasPending = $stmt->get_result()->num_rows > 0;

            $_SESSION['step'] = $hasPending ? "locked" : "choose";
            $step = $_SESSION['step'];
        }
    }

// step 2 backup code
    if ($action === 'verify_backup') {

        $user_id = $_SESSION['user_id'] ?? 0;
        $code = trim($_POST['backup_code']);

        if (!$user_id) {
            $message = "Session expired.";
            $_SESSION['step'] = "email";
        } else {

            $stmt = $conn->prepare("
                SELECT id FROM backup_codes
                WHERE user_id = ? AND code = ? AND used = 0
            ");
            $stmt->bind_param("is", $user_id, $code);
            $stmt->execute();

            if ($stmt->get_result()->num_rows > 0) {

                // mark used
                $stmt = $conn->prepare("
                    UPDATE backup_codes
                    SET used = 1
                    WHERE user_id = ? AND code = ?
                ");
                $stmt->bind_param("is", $user_id, $code);
                $stmt->execute();

                $_SESSION['reset_user_id'] = $user_id;

                session_write_close();
                header("Location: reset_password.php");
                exit();
            } else {
                $message = "Invalid backup code.";
                $_SESSION['step'] = "choose";
            }
        }
    }

// step 3 admin req
    if ($action === 'admin_request') {

        $user_id = $_SESSION['user_id'] ?? 0;

        if (!$user_id) {
            $message = "Session expired.";
            $_SESSION['step'] = "email";
        } else {

            $stmt = $conn->prepare("
                SELECT id FROM recovery_requests 
                WHERE user_id = ? AND status = 'pending'
            ");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();

            if ($stmt->get_result()->num_rows > 0) {

                // IMPORTANT: DO NOT show 2 messages anymore
                $message = "You already have a pending request.";
            } else {

                $reason = "Forgot password - admin recovery request";

                $stmt = $conn->prepare("
                    INSERT INTO recovery_requests (user_id, reason, status)
                    VALUES (?, ?, 'pending')
                ");
                $stmt->bind_param("is", $user_id, $reason);
                $stmt->execute();

                $message = "Request sent. Please wait for admin approval.";
            }

            $_SESSION['step'] = "locked";
        }
    }
}

$step = $_SESSION['step'] ?? "email";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Recovery</title>
    <link rel="icon" href="assets/image/alumni_plp_newicon.png">

    <style>
        body {
            font-family: Arial;
            background: #f4f6f9;
            padding: 40px;
        }

        .box {
            max-width: 420px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
        }

        button {
            width: 100%;
            padding: 10px;
            margin-top: 12px;
            background: #007bff;
            color: white;
            border: none;
        }

        .danger {
            background: #dc3545;
        }

        .message {
            margin-bottom: 15px;
            padding: 10px;
            background: #e7f3ff;
            border-left: 4px solid #007bff;
        }
    </style>
</head>

<body>

    <div class="box">
        <h2>Account Recovery</h2>

        <?php if ($message): ?><div class="message"><?= htmlspecialchars($message) ?></div><?php endif; ?>

        <!-- EMAIL STEP -->
        <?php if ($step === "email"): ?>
            <form method="POST">
                <input type="hidden" name="action" value="email">
                <input type="email" name="email" placeholder="Enter email" required>
                <button>Continue</button>
            </form>
        <?php endif; ?>
        <!-- CHOOSE STEP -->
        <?php if ($step === "choose"): ?>
            <p>Choose recovery method:</p>

            <form method="POST">
                <input type="hidden" name="action" value="verify_backup">
                <input type="text" name="backup_code" placeholder="Backup code" required>
                <button>Use Backup Code</button>
            </form>

            <form method="POST">
                <input type="hidden" name="action" value="admin_request">
                <button class="danger">Request Admin Reset</button>
            </form>
        <?php endif; ?>

        <!-- LOCKED STEP -->
        <?php if ($step === "locked"): ?>
            <p class="message">
                You already have a pending recovery request.<br>
                Please wait for admin approval.
            </p>
            <form method="POST">
                <input type="hidden" name="reset_all" value="1">
                <button>Back to Login</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>