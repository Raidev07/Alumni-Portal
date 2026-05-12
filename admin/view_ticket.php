<?php
include("../backend/db_admin.php");
session_start();

/*
|--------------------------------------------------------------------------
| ADMIN CHECK
|--------------------------------------------------------------------------
*/
if (
    !isset($_SESSION['user_id']) ||
    $_SESSION['role'] !== 'admin'
) {
    header("Location: ../login.php");
    exit();
}

/*
|--------------------------------------------------------------------------
| VALIDATE ID
|--------------------------------------------------------------------------
*/
if (!isset($_GET['id'])) {
    header("Location: tickets.php");
    exit();
}

$ticket_id = intval($_GET['id']);

/*
|--------------------------------------------------------------------------
| GET TICKET
|--------------------------------------------------------------------------
*/
$stmt = $conn->prepare("
    SELECT *
    FROM tickets
    WHERE id = ?
");

$stmt->bind_param("i", $ticket_id);
$stmt->execute();

$ticket = $stmt->get_result()->fetch_assoc();

if (!$ticket) {
    die("Ticket not found.");
}

/*
|--------------------------------------------------------------------------
| SEND REPLY
|--------------------------------------------------------------------------
*/
if (isset($_POST['send_reply'])) {

    $message = trim($_POST['message']);

    if (!empty($message)) {

        $sender = "admin";
        $user_id = $_SESSION['user_id'];

        $stmt = $conn->prepare("
            INSERT INTO ticket_replies
            (ticket_id, sender_type, user_id, message)
            VALUES (?, ?, ?, ?)
        ");

        $stmt->bind_param(
            "isis",
            $ticket_id,
            $sender,
            $user_id,
            $message
        );

        $stmt->execute();

        /*
        |--------------------------------------------------------------------------
        | UPDATE STATUS
        |--------------------------------------------------------------------------
        */
        mysqli_query($conn, "
            UPDATE tickets
            SET status='in_progress'
            WHERE id='$ticket_id'
        ");

        header("Location: view_ticket.php?id=$ticket_id");
        exit();
    }
}

/*
|--------------------------------------------------------------------------
| UPDATE STATUS
|--------------------------------------------------------------------------
*/
if (isset($_POST['update_status'])) {

    $status = $_POST['status'];

    $stmt = $conn->prepare("
        UPDATE tickets
        SET status = ?
        WHERE id = ?
    ");

    $stmt->bind_param("si", $status, $ticket_id);
    $stmt->execute();

    header("Location: view_ticket.php?id=$ticket_id");
    exit();
}

/*
|--------------------------------------------------------------------------
| FETCH REPLIES
|--------------------------------------------------------------------------
*/
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
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Ticket | Alumni Association</title>
    <link rel="icon" href="../assets/image/alumni_plp_newicon.png" type="image/x-icon">
    <?php include('includes/global_styles.php'); ?>

    <style>
        .chat-box {
            max-height: 500px;
            overflow-y: auto;
            padding: 20px;
            border-radius: 10px;

            background: var(--bs-body-bg);
            color: var(--bs-body-color);
        }

        .chat-box {
            border: 1px solid rgba(0, 0, 0, 0.1);
        }

        body.dark-mode .chat-box {
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .message {
            margin-bottom: 20px;
        }

        .message.admin {
            text-align: right;
        }

        .bubble {
            display: inline-block;
            padding: 12px 16px;
            border-radius: 12px;
            max-width: 70%;

            color: var(--bs-body-color);
        }

        .user .bubble {
            background: var(--bs-body-bg);
            border: 1px solid rgba(0, 0, 0, 0.1);
        }

        .admin .bubble {
            background: #0d6efd;
            color: #fff;
        }

        .time {
            font-size: 12px;
            margin-top: 5px;
            opacity: 0.8;
            color: inherit;
        }

        .user .time {
            color: #6c757d;
        }

        .admin .time {
            color: rgba(255, 255, 255, 0.85);
        }
    </style>
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">

    <div class="app-wrapper">

        <?php include('includes/navbar.php'); ?>
        <?php include('includes/sidebar.php'); ?>

        <main class="app-main">
            <div class="app-content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">Ticket #<?= $ticket['id'] ?></h3>
                        </div>

                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="tickets.php">Tickets</a></li>
                                <li class="breadcrumb-item active">View Ticket</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="app-content">
                <div class="container-fluid">

                    <div class="card card-primary card-outline">

                        <div class="card-header">

                            <h5>
                                <?= htmlspecialchars($ticket['subject']) ?>
                            </h5>

                            <small>
                                <?= htmlspecialchars($ticket['full_name']) ?>
                                —
                                <?= htmlspecialchars($ticket['email']) ?>
                            </small>

                        </div>

                        <div class="card-body">

                            <!-- STATUS -->

                            <form method="POST" class="mb-4">

                                <div class="row">

                                    <div class="col-md-4">

                                        <select name="status" class="form-select">

                                            <option value="open"
                                                <?= $ticket['status'] == 'open' ? 'selected' : '' ?>>
                                                Open
                                            </option>

                                            <option value="in_progress"
                                                <?= $ticket['status'] == 'in_progress' ? 'selected' : '' ?>>
                                                In Progress
                                            </option>

                                            <option value="resolved"
                                                <?= $ticket['status'] == 'resolved' ? 'selected' : '' ?>>
                                                Resolved
                                            </option>

                                        </select>

                                    </div>

                                    <div class="col-md-2">

                                        <button class="btn btn-success"
                                            name="update_status">

                                            Update

                                        </button>

                                    </div>

                                </div>

                            </form>

                            <!-- CHAT -->

                            <div class="chat-box">

                                <?php while ($reply = mysqli_fetch_assoc($replies)): ?>

                                    <div class="message <?= $reply['sender_type'] ?>">

                                        <div class="bubble">

                                            <?= nl2br(htmlspecialchars($reply['message'])) ?>

                                            <div class="time">
                                                <?= date("M d, Y h:i A", strtotime($reply['created_at'])) ?>
                                            </div>

                                        </div>

                                    </div>

                                <?php endwhile; ?>

                            </div>

                            <?php if ($ticket['status'] === 'resolved'): ?>

                                <div style="
                                        padding:15px;
                                        border-radius:10px;
                                        text-align:center;
                                        font-weight:600;
                                    ">
                                    This ticket is resolved and archived.<br>
                                    You can view it but cannot send replies anymore.
                                </div>
                            <?php else: ?>
                                <!-- REPLY -->

                                <form method="POST" class="mt-4">

                                    <div class="mb-3">

                                        <textarea
                                            name="message"
                                            class="form-control"
                                            rows="4"
                                            placeholder="Type your reply..."
                                            required></textarea>

                                    </div>

                                    <button class="btn btn-primary"
                                        name="send_reply">

                                        Send Reply

                                    </button>

                                </form>
                            <?php endif; ?>
                        </div>

                    </div>

                </div>
            </div>

        </main>

        <?php include("includes/footer.php"); ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function logout(event) {
            event.preventDefault();

            Swal.fire({
                title: "Are you sure?",
                text: "You will be logged out.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#dc3545",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Yes, log out",
                cancelButtonText: "Cancel"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "../logout.php";
                }
            });
        }
    </script>
    <?php if (!empty($success)): ?>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                let toast = document.createElement("div");
                toast.innerText = "<?= $success ?>";

                toast.style.position = "fixed";
                toast.style.top = "20px";
                toast.style.right = "20px";
                toast.style.background = "#28a745";
                toast.style.color = "white";
                toast.style.padding = "12px 18px";
                toast.style.borderRadius = "6px";
                toast.style.zIndex = "9999";
                toast.style.fontSize = "14px";

                document.body.appendChild(toast);

                setTimeout(() => toast.remove(), 3000);
            });
        </script>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                let toast = document.createElement("div");
                toast.innerText = "<?= $error ?>";

                toast.style.position = "fixed";
                toast.style.top = "20px";
                toast.style.right = "20px";
                toast.style.background = "#dc3545";
                toast.style.color = "white";
                toast.style.padding = "12px 18px";
                toast.style.borderRadius = "6px";
                toast.style.zIndex = "9999";
                toast.style.fontSize = "14px";

                document.body.appendChild(toast);

                setTimeout(() => toast.remove(), 3000);
            });
        </script>
    <?php endif; ?>
</body>

</html>