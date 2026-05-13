<?php
include("../backend/db_admin.php");
session_start();

include("includes/flash.php");
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
| BASE FILE (IMPORTANT FIX - PREVENT "NOT FOUND")
|--------------------------------------------------------------------------
*/
$baseFile = basename($_SERVER['PHP_SELF']);

/*
|--------------------------------------------------------------------------
| FILTER SYSTEM
|--------------------------------------------------------------------------
*/
$allowedFilters = ['all', 'open', 'in_progress', 'resolved'];
$filter = $_GET['filter'] ?? 'all';

if (!in_array($filter, $allowedFilters)) {
    $filter = 'all';
}

if ($filter === 'resolved') {

    $query = "
        SELECT *
        FROM tickets
        WHERE status = 'resolved'
        ORDER BY created_at DESC
    ";
} elseif ($filter === 'in_progress') {

    $query = "
        SELECT *
        FROM tickets
        WHERE status = 'in_progress'
        ORDER BY created_at DESC
    ";
} elseif ($filter === 'open') {

    $query = "
        SELECT *
        FROM tickets
        WHERE status = 'open'
        ORDER BY created_at DESC
    ";
} else {

    $query = "
        SELECT *
        FROM tickets
        ORDER BY created_at DESC
    ";
}

$ret = mysqli_query($conn, $query);

if (!$ret) {
    flash("error", "Database Error", "Failed to load tickets. Please try again.");
    $ret = false;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support Tickets | Alumni Association</title>
    <link rel="icon" href="../assets/image/alumni_plp_newicon.png" type="image/x-icon">

    <?php include('includes/global_styles.php'); ?>

    <style>
        .badge-open {
            background: #0d6efd;
            color: #fff;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-progress {
            background: #ffc107;
            color: #000;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-resolved {
            background: #198754;
            color: #fff;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .table td,
        .table th {
            vertical-align: middle;
        }

        .filter-bar {
            display: flex;
            gap: 10px;
            padding: 15px;
        }

        .filter-bar a {
            text-decoration: none;
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 14px;
            color: #fff;
        }

        .btn-all {
            background: #6c757d;
        }

        .btn-active {
            background: #0d6efd;
        }

        .btn-archived {
            background: #198754;
        }

        .active-filter {
            opacity: 0.8;
            transform: scale(0.98);
        }

        .btn-inprog {
            background: #ffc107;
        }
    </style>
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">

    <div class="app-wrapper">

        <?php include('includes/navbar.php'); ?>
        <?php include('includes/sidebar.php'); ?>

        <main class="app-main">

            <!-- HEADER -->
            <div class="app-content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">Support Tickets</h3>
                        </div>

                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Support Tickets</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CONTENT -->
            <div class="app-content">
                <div class="container-fluid">

                    <div class="card card-primary card-outline">

                        <div class="card-header">
                            <div class="card-title">All Tickets</div>
                        </div>

                        <!-- FILTER BUTTONS (FIXED LINKS) -->
                        <div class="filter-bar">

                            <a href="<?= $baseFile ?>?filter=all"
                                class="btn-all <?= $filter == 'all' ? 'active-filter' : '' ?>">
                                All
                            </a>

                            <a href="<?= $baseFile ?>?filter=open"
                                class="btn-active <?= $filter == 'open' ? 'active-filter' : '' ?>">
                                Open
                            </a>

                            <a href="<?= $baseFile ?>?filter=in_progress"
                                class="btn-inprog <?= $filter == 'in_progress' ? 'active-filter' : '' ?>">
                                In Progress
                            </a>

                            <a href="<?= $baseFile ?>?filter=resolved"
                                class="btn-archived <?= $filter == 'resolved' ? 'active-filter' : '' ?>">
                                Archived/Resolved
                            </a>

                        </div>

                        <div class="card-body p-0">

                            <div class="table-responsive">
                                <?php if ($ret === false): ?>
                                    <div class="p-3 text-danger">
                                        Unable to load tickets due to a system error.
                                    </div>
                                <?php elseif (mysqli_num_rows($ret) === 0): ?>
                                    <div class="p-3 text-muted text-center">
                                        No tickets found.
                                    </div>
                                <?php else: ?>

                                    <table class="table table-striped table-hover" id="table-data">

                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Full Name</th>
                                                <th>Email</th>
                                                <th>Subject</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            <?php if ($ret && mysqli_num_rows($ret) > 0): ?>

                                                <?php while ($row = mysqli_fetch_assoc($ret)): ?>

                                                    <tr>

                                                        <td>#<?= $row['id'] ?></td>

                                                        <td><?= htmlspecialchars($row['full_name']) ?></td>

                                                        <td><?= htmlspecialchars($row['email']) ?></td>

                                                        <td><?= htmlspecialchars($row['subject']) ?></td>

                                                        <td>

                                                            <?php if ($row['status'] == 'open'): ?>
                                                                <span class="badge badge-open">Open</span>

                                                            <?php elseif ($row['status'] == 'in_progress'): ?>
                                                                <span class="badge badge-progress">In Progress</span>

                                                            <?php else: ?>
                                                                <span class="badge badge-resolved">Resolved</span>
                                                            <?php endif; ?>

                                                        </td>

                                                        <td>
                                                            <?= date("M d, Y h:i A", strtotime($row['created_at'])) ?>
                                                        </td>

                                                        <td>
                                                            <a href="view_ticket.php?id=<?= $row['id'] ?>"
                                                                class="btn btn-sm btn-primary">
                                                                View
                                                            </a>
                                                        </td>

                                                    </tr>

                                                <?php endwhile; ?>

                                            <?php else: ?>

                                                <tr>
                                                    <td colspan="7" class="text-center text-danger">
                                                        No tickets found.
                                                    </td>
                                                </tr>

                                            <?php endif; ?>

                                        </tbody>

                                    </table>
                                <?php endif; ?>
                            </div>

                        </div>

                    </div>

                </div>
            </div>

        </main>

        <?php include("includes/footer.php"); ?>

    </div>

    <?php include("includes/flash-swal.php"); ?>
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
</body>

</html>