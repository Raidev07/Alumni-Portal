<?php
session_start();

if (!isset($_SESSION['temp_user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>2FA Verification</title>
    <link rel="icon" href="assets/image/alumni_plp_newicon.png">

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
            border: 1px solid #d9e8e3;
            border-radius: 10px;
            background: #f8faf8;
            transition: background 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease;
        }

        input:hover {
            background: #f0f5f2;
        }

        input:focus {
            outline: none;
            border-color: #006e14;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(0, 110, 20, 0.12);
        }

        button {
            margin-top: 15px;
            padding: 10px 15px;
            background: #006e14;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        button:hover {
            background: #006e14;
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