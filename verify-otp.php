<?php
session_start();

if (!isset($_SESSION['temp_user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>2FA Verification</title>

    <style>
        body {
            font-family: Arial;
            background: #f4f6f9;
            text-align: center;
            padding-top: 80px;
        }

        .box {
            background: white;
            width: 350px;
            margin: auto;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        input {
            width: 90%;
            padding: 10px;
            margin-top: 10px;
            font-size: 16px;
        }

        button {
            margin-top: 15px;
            padding: 10px 15px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        button:hover {
            background: #0056b3;
        }

        .error {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>

    <div class="box">

        <h2>2FA Verification</h2>

        <?php if (isset($_GET['error'])): ?>
            <div class="error">Invalid OTP. Try again.</div>
        <?php endif; ?>

        <form method="POST" action="backend/otp_process.php">

            <input type="text" name="otp" placeholder="Enter 6-digit code" maxlength="6" required>

            <br>

            <button type="submit">Verify</button>

        </form>

    </div>

</body>

</html>