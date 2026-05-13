<?php
session_start();
include("backend/db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// filter 
$tab = $_GET['tab'] ?? 'open';

if ($tab === 'archive') {
    $stmt = $conn->prepare("
        SELECT *
        FROM tickets
        WHERE user_id = ? AND status = 'resolved'
        ORDER BY created_at DESC
    ");
} else {
    $stmt = $conn->prepare("
        SELECT *
        FROM tickets
        WHERE user_id = ? AND status != 'resolved'
        ORDER BY created_at DESC
    ");
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$tickets = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Tickets</title>
    <link rel="icon" href="assets/image/alumni_plp_newicon.png">

    <link rel="stylesheet" href="assets/css/contact.css">
    <link rel="stylesheet" href="assets/css/alumni_homepage.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        /* LAYOUT */
        .ticket-layout {
            display: flex;
            gap: 20px;
        }

        /* SIDEBAR */
        .ticket-sidebar {
            width: 220px;
            background: #fff;
            border-radius: 12px;
            padding: 15px;
            height: fit-content;
        }

        .ticket-sidebar a {
            display: block;
            padding: 10px 12px;
            margin-bottom: 8px;
            border-radius: 8px;
            text-decoration: none;
            color: #333;
            font-weight: 500;
        }

        .ticket-sidebar a.active {
            background: #0d6efd;
            color: #fff;
        }

        /* TABLE */
        .ticket-table {
            flex: 1;
            overflow-x: auto;
        }

        .ticket-table table {
            width: 100%;
            border-collapse: collapse;
        }

        .ticket-table th {
            background: #f5f7fb;
            padding: 12px;
            text-align: left;
        }

        .ticket-table td {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }

        .ticket-table tr:hover {
            background: #fafafa;
        }

        /* BADGES */
        .badge-open {
            background: #0d6efd;
            color: #fff;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
        }

        .badge-progress {
            background: #ffc107;
            color: #000;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
        }

        .badge-resolved {
            background: #198754;
            color: #fff;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
        }
    </style>
</head>

<body>

    <?php include('includes/navbarhome.php'); ?>

    <section class="contact-section">
        <div class="contact-wrapper">

            <div class="contact-header">
                <span class="section-tag">My Support</span>
                <p class="section-sub">Manage your tickets & archive</p>
            </div>

            <div class="contact-form-card">
                <h3 class="form-title">Ticket Center</h3>
                <div class="ticket-layout">
                    <!-- SIDEBAR -->
                    <div class="ticket-sidebar">
                        <a href="my_tickets.php?tab=open" class="<?= $tab === 'open' ? 'active' : '' ?>">
                            <i class="fas fa-inbox"></i> My Tickets
                        </a>
                        <a href="my_tickets.php?tab=archive" class="<?= $tab === 'archive' ? 'active' : '' ?>">
                            <i class="fas fa-archive"></i> Archive
                        </a>
                    </div>

                    <!-- TABLE -->
                    <div class="ticket-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Subject</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($tickets->num_rows > 0): ?>
                                    <?php while ($ticket = $tickets->fetch_assoc()): ?>
                                        <tr>
                                            <td>#<?= $ticket['id'] ?></td>
                                            <td><?= htmlspecialchars($ticket['subject']) ?></td>

                                            <td>
                                                <?php if ($ticket['status'] == 'open'): ?>
                                                    <span class="badge-open">Open</span>

                                                <?php elseif ($ticket['status'] == 'in_progress'): ?>
                                                    <span class="badge-progress">In Progress</span>

                                                <?php else: ?>
                                                    <span class="badge-resolved">Resolved</span>
                                                <?php endif; ?>
                                            </td>

                                            <td>
                                                <?= date("M d, Y h:i A", strtotime($ticket['created_at'])) ?>
                                            </td>

                                            <td>
                                                <a href="view_ticket.php?id=<?= $ticket['id'] ?>" class="submit-btn" style="padding:6px 10px;"> View</a>
                                            </td>
                                        </tr>

                                    <?php endwhile; ?>
                                <?php else: ?>

                                    <tr>
                                        <td colspan="5" style="text-align:center; padding:20px;">
                                            No tickets found.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include('includes/logoutmodal.php'); ?>
    <script src="assets/js/alumni_homepage.js"></script>
</body>
</html>