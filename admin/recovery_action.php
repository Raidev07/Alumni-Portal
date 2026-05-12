<?php
session_start();
include("../backend/db_admin.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/../PHPMailer/src/SMTP.php';
require_once __DIR__ . '/../PHPMailer/src/Exception.php';

/* =========================
   AUTH CHECK
========================= */
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

/* =========================
   VALIDATION
========================= */
if (!isset($_POST['id'], $_POST['action'])) {
    $_SESSION['recovery_msg'] = "Invalid request.";
    header("Location: recovery_requests.php");
    exit();
}

$id = (int) $_POST['id'];
$action = $_POST['action'];

/* =========================
   APPROVE
========================= */
if ($action === 'approve') {

    // 1. Get request + user
    $stmt = $conn->prepare("
        SELECT r.user_id, u.email
        FROM recovery_requests r
        JOIN users u ON u.id = r.user_id
        WHERE r.id = ?
    ");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $request = $stmt->get_result()->fetch_assoc();

    if (!$request) {
        $_SESSION['recovery_msg'] = "Request not found.";
        header("Location: recovery_requests.php");
        exit();
    }

    $user_id = $request['user_id'];
    $email   = $request['email'];

    // 2. Generate TEMP PASSWORD
    $tempPassword = substr(str_shuffle("ABCDEFGHJKLMNPQRSTUVWXYZ23456789abcdefghjkmnpqrstuvwxyz"), 0, 10);
    $hashed = password_hash($tempPassword, PASSWORD_DEFAULT);

    // 3. Update user password + force change flag
    $stmt = $conn->prepare("
        UPDATE users 
        SET password = ?, force_password_change = 1
        WHERE id = ?
    ");
    $stmt->bind_param("si", $hashed, $user_id);
    $stmt->execute();

    // 4. Mark request approved
    $stmt = $conn->prepare("
        UPDATE recovery_requests 
        SET status = 'approved'
        WHERE id = ?
    ");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // 5. SEND EMAIL
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;

        $mail->Username = 'pohlovesyou@gmail.com';
        $mail->Password = 'gieoihygssbcbtvh';

        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('pohlovesyou@gmail.com', 'Alumni System');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = "Account Recovery Approved";

        $mail->Body = "
            <div style='font-family:Arial, sans-serif; background:#f4f6f9; padding:30px;'>

                <div style='max-width:600px; margin:auto; background:#ffffff; border-radius:10px; overflow:hidden; box-shadow:0 4px 15px rgba(0,0,0,0.1);'>

                    <!-- HEADER -->
                    <div style='background:#0d6efd; padding:20px; text-align:center; color:white;'>
                        <h2 style='margin:0;'>Alumni System</h2>
                    </div>

                    <!-- BODY -->
                    <div style='padding:30px; color:#333;'>

                        <h3 style='margin-top:0;'>Account Recovery Approved</h3>

                        <p>Your account recovery request has been approved by the administrator.</p>

                        <p style='margin-bottom:10px;'>Your temporary password is:</p>

                        <div style='background:#f8d7da; padding:15px; text-align:center; border-radius:8px; margin:15px 0;'>
                            <h2 style='margin:0; color:#dc3545; letter-spacing:2px;'>
                                $tempPassword
                            </h2>
                        </div>

                        <p style='color:#555;'>
                            ⚠ Please login immediately and change your password for security purposes.
                        </p>

                        <div style='text-align:center; margin-top:25px;'>
                            <a href='http://localhost/MAIN-PROJECT/Alumni-Portal/login.php'
                                style='background:#28a745; color:white; padding:12px 25px;
                                text-decoration:none; border-radius:6px; display:inline-block; font-weight:bold;'>
                                Login Now
                            </a>
                        </div>

                    </div>

                    <!-- FOOTER -->
                    <div style='background:#f1f1f1; text-align:center; padding:15px; font-size:12px; color:#777;'>
                        © " . date('Y') . " Alumni System. All rights reserved.
                    </div>

                </div>
            </div>
            ";

        $mail->send();

        $_SESSION['recovery_msg'] = "Approved + temporary password sent.";
    } catch (Exception $e) {
        $_SESSION['recovery_msg'] = "Approved but email failed: " . $mail->ErrorInfo;
    }

    /* =========================
    REJECT
========================= */
} elseif ($action === 'reject') {

    $stmt = $conn->prepare("
        UPDATE recovery_requests
        SET status = 'rejected'
        WHERE id = ?
    ");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $_SESSION['recovery_msg'] = "Request rejected.";
}

header("Location: recovery_requests.php");
exit();
