<?php
session_start();
include("backend/db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/*
|----------------------------------------------------------------------
| TAB SYSTEM (MY TICKETS / ARCHIVE)
|----------------------------------------------------------------------
*/
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
            gap: 24px;
        }

        /* SIDEBAR */
        .ticket-sidebar {
            width: 220px;
            background: #ffffff;
            border: 1px solid #e8f0eb;
            border-radius: 12px;
            padding: 20px 15px;
            height: fit-content;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .ticket-sidebar a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 14px;
            margin-bottom: 8px;
            border-radius: 8px;
            text-decoration: none;
            color: #0f172a;
            font-weight: 500;
            font-size: 14px;
            transition: all 0.25s ease;
            border-left: 3px solid transparent;
        }

        .ticket-sidebar a:hover {
            background: #edfaee;
            color: #006e14;
        }

        .ticket-sidebar a.active {
            background: #edfaee;
            color: #006e14;
            border-left-color: #006e14;
            font-weight: 600;
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
            background: #f8fafc;
            padding: 14px 12px;
            text-align: left;
            font-weight: 600;
            color: #334155;
            font-size: 13px;
            border-bottom: 2px solid #e8f0eb;
            letter-spacing: 0.3px;
        }

        .ticket-table td {
            padding: 14px 12px;
            border-bottom: 1px solid #e8f0eb;
            color: #0f172a;
            font-size: 14px;
        }

        .ticket-table tbody tr:hover {
            background: #f8fafc;
        }

        /* BADGES */
        .badge-open {
            display: inline-block;
            background: #dcfce7;
            color: #166534;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-progress {
            display: inline-block;
            background: #fef3c7;
            color: #92400e;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-resolved {
            display: inline-block;
            background: #edfaee;
            color: #006e14;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
        }

        /* FORM TITLE CONSISTENCY */
        .form-title {
            font-size: 24px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 20px;
        }

        /* SECTION TAG SPACING */
        .section-tag {
            margin-top: 20px;
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

                        <a href="my_tickets.php?tab=open"
                            class="<?= $tab === 'open' ? 'active' : '' ?>">
                            <i class="fas fa-inbox"></i> My Tickets
                        </a>

                        <a href="my_tickets.php?tab=archive"
                            class="<?= $tab === 'archive' ? 'active' : '' ?>">
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
                                                <a href="view_ticket.php?id=<?= $ticket['id'] ?>"
                                                    style="display: inline-flex; align-items: center; gap: 8px; padding: 8px 16px; background: #006e14; color: #ffffff; border-radius: 8px; text-decoration: none; font-size: 13px; font-weight: 600; transition: all 0.25s ease; border: none; cursor: pointer;">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
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