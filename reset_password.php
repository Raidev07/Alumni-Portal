<?php
include("backend/db.php");

$token = $_GET['token'] ?? '';

if (!$token) {
    die("Invalid access.");
}

$stmt = $conn->prepare("
    SELECT r.user_id
    FROM recovery_requests r
    WHERE r.reset_token = ?
    AND r.token_expiry > NOW()
    AND r.status = 'approved'
");

$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Invalid or expired link.");
}

$user_id = $result->fetch_assoc()['user_id'];

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $new = $_POST['new_password'];
    $confirm = $_POST['confirm_password'];

    if ($new !== $confirm) {
        $message = "Passwords do not match.";
    } else {

        $hashed = password_hash($new, PASSWORD_DEFAULT);

        // update password
        $stmt = $conn->prepare("
            UPDATE users SET password = ? WHERE id = ?
        ");
        $stmt->bind_param("si", $hashed, $user_id);
        $stmt->execute();

        // invalidate token
        $stmt = $conn->prepare("
            UPDATE recovery_requests
            SET reset_token = NULL,
                token_expiry = NULL,
                status = 'used'
            WHERE user_id = ?
        ");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();

        header("Location: login.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Reset Password</title>
</head>

<body style="font-family:Arial;background:#f4f6f9;padding:40px;">

    <div style="max-width:400px;margin:auto;background:#fff;padding:20px;border-radius:10px;">

        <h2>Reset Password</h2>

        <?php if ($message): ?>
            <p><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <form method="POST">
            <input type="password" name="new_password" placeholder="New Password" required><br><br>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required><br><br>
            <button type="submit">Change Password</button>
        </form>

    </div>

</body>

</html>