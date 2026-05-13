<?php
session_start();
include("backend/db.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $user_id = $_SESSION['user_id'] ?? null;

    $full_name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    if (
        empty($full_name) ||
        empty($email) ||
        empty($subject) ||
        empty($message)
    ) {
        header("Location: contact.php?error=empty");
        exit();
    }

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

    // first msg save
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
