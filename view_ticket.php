<?php
session_start();
include("backend/db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if (!isset($_GET['id'])) {
    header("Location: my_tickets.php");
    exit();
}

$ticket_id = intval($_GET['id']);

$stmt = $conn->prepare("
    SELECT *
    FROM tickets
    WHERE id = ? AND user_id = ?
");

$stmt->bind_param("ii", $ticket_id, $user_id);
$stmt->execute();

$ticket = $stmt->get_result()->fetch_assoc();

if (!$ticket) {
    die("Ticket not found.");
}

if (isset($_POST['send_reply'])) {

    $message = trim($_POST['message']);

    if (!empty($message)) {

        $stmt = $conn->prepare("
            INSERT INTO ticket_replies
            (ticket_id, sender_type, user_id, message)
            VALUES (?, 'user', ?, ?)
        ");

        $stmt->bind_param("iis", $ticket_id, $user_id, $message);
        $stmt->execute();

        header("Location: view_ticket.php?id=$ticket_id");
        exit();
    }
}

$replies = mysqli_query($conn, "
    SELECT *
    FROM ticket_replies
    WHERE ticket_id = '$ticket_id'
    ORDER BY created_at ASC
");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Conversation</title>
    <link rel="icon" href="assets/image/alumni_plp_newicon.png">

    <link rel="stylesheet" href="assets/css/contact.css">
    <link rel="stylesheet" href="assets/css/alumni_homepage.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        .chat-box {
            max-height: 450px;
            overflow-y: auto;
            padding: 15px;
            background: #f5f7fb;
            border-radius: 12px;
            margin-bottom: 20px;
        }

        .message {
            margin-bottom: 12px;
            display: flex;
        }

        .user {
            justify-content: flex-end;
        }

        .admin {
            justify-content: flex-start;
        }

        .bubble {
            display: inline-block;
            padding: 12px 15px;
            border-radius: 14px;
            max-width: 70%;
            font-size: 14px;
        }

        .user .bubble {
            background: #028f21;
            color: #fff;
        }

        .admin .bubble {
            background: #e5e7eb;
            color: #111;
        }

        .time {
            font-size: 11px;
            opacity: 0.7;
            margin-top: 5px;
        }

        textarea {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            border: 1px solid #ddd;
            resize: none;
            font-family: inherit;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 16px;
            background: #006e14;
            color: #ffffff;
            border-radius: 10px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: background 0.25s ease, transform 0.2s ease;
        }

        .back-link:hover {
            background: #005210;
            transform: translateY(-1px);
        }
    </style>
</head>

<body>

    <?php include('includes/navbarhome.php'); ?>

    <!-- CONTACT STYLE WRAPPER -->
    <section class="contact-section">
        <div class="contact-wrapper">

            <div class="contact-header">
                <span class="section-tag">Support Ticket</span>
                <p class="section-sub">
                    Conversation with admin support team
                </p>
            </div>
            <div style="margin-bottom: 15px;">
                <a href="my_tickets.php" class="back-link">
                    <i class="fas fa-arrow-left"></i> Back to My Tickets
                </a>
            </div>

            <div class="contact-form-card">

                <h3 class="form-title">
                    <?= htmlspecialchars($ticket['subject']) ?>
                </h3>

                <p class="form-sub">
                    Status:
                    <b><?= ucfirst($ticket['status']) ?></b>
                </p>

                <!-- CHAT BOX -->
                <div class="chat-box">

                    <?php while ($row = mysqli_fetch_assoc($replies)): ?>

                        <div class="message <?= $row['sender_type'] ?>">

                            <div class="bubble">

                                <?= nl2br(htmlspecialchars($row['message'])) ?>

                                <div class="time">
                                    <?= date("M d, Y h:i A", strtotime($row['created_at'])) ?>
                                </div>

                            </div>

                        </div>

                    <?php endwhile; ?>

                </div>

                <?php if ($ticket['status'] === 'resolved'): ?>

                    <!-- READ ONLY MODE -->
                    <div style="
                            padding:15px;
                            background:#e9ecef;
                            border-radius:10px;
                            margin-top:15px;
                        ">
                        <b>This ticket is resolved (Archived).</b><br>
                        You can view this conversation but cannot send messages anymore.
                    </div>

                <?php else: ?>

                    <!-- REPLY FORM -->
                    <form method="POST" class="contact-form">

                        <div class="form-group">
                            <label>Reply Message</label>
                            <textarea name="message" rows="4" placeholder="Type your reply..." required></textarea>
                        </div>

                        <button class="submit-btn" name="send_reply">
                            Send Reply <i class="fas fa-paper-plane"></i>
                        </button>

                    </form>
                <?php endif; ?>

            </div>
        </div>
    </section>

    <?php include('includes/logoutmodal.php'); ?>

    <script src="assets/js/alumni_homepage.js"></script>
</body>

</html>