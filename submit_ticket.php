<?php
session_start();
include("backend/db.php");

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: contact.php");
    exit();
}

//    FORM DATA

$full_name = htmlspecialchars(trim($_POST['name']));
$email     = htmlspecialchars(trim($_POST['email']));
$subject   = htmlspecialchars(trim($_POST['subject']));
$message   = htmlspecialchars(trim($_POST['message']));

$isLoggedIn = isset($_SESSION['user_id']);
$user_id = $isLoggedIn ? $_SESSION['user_id'] : null;

//    VALIDATION
if (
    empty($full_name) ||
    empty($email) ||
    empty($subject) ||
    empty($message)
) {
    header("Location: contact.php?error=empty");
    exit();
}

//    CASE 1: LOGGED IN TO TICKET SYSTEM

if ($isLoggedIn) {

    $stmt = $conn->prepare("
        INSERT INTO tickets
        (user_id, full_name, email, subject, message)
        VALUES (?, ?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "issss",
        $user_id,
        $full_name,
        $email,
        $subject,
        $message
    );

    if ($stmt->execute()) {

        $ticket_id = $stmt->insert_id;

        // first message in thread
        $sender = "user";

        $reply = $conn->prepare("
            INSERT INTO ticket_replies
            (ticket_id, sender_type, user_id, message)
            VALUES (?, ?, ?, ?)
        ");

        $reply->bind_param(
            "isis",
            $ticket_id,
            $sender,
            $user_id,
            $message
        );

        $reply->execute();

        header("Location: contact.php?success=1");
        exit();

    } else {
        header("Location: contact.php?error=1");
        exit();
    }
}


//    CASE 2: GUEST TO EMAIL SYSTEM
else {

    $mail = new PHPMailer(true);

    try {

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;

        $mail->Username = 'pohlovesyou@gmail.com';
        $mail->Password = 'gieoihygssbcbtvh';

        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('pohlovesyou@gmail.com', 'Alumni Portal Support');
        $mail->addAddress('pohlovesyou@gmail.com');

        // allow reply directly to user email
        $mail->addReplyTo($email, $full_name);

        $mail->isHTML(true);
        $mail->Subject = "Guest Message: " . $subject;

        $mail->Body = "
            <div style='font-family:Arial;padding:15px'>
                <h2>New Guest Message</h2>

                <p><b>Name:</b> $full_name</p>
                <p><b>Email:</b> $email</p>
                <p><b>Subject:</b> $subject</p>

                <hr>

                <p style='white-space:pre-line'>$message</p>
            </div>
        ";

        $mail->send();

        header("Location: contact.php?success=1");
        exit();

    } catch (Exception $e) {

        header("Location: contact.php?error=1");
        exit();
    }
}
?>