<?php
include("../backend/db_admin.php");
session_start();

if (
    !isset($_SESSION['user_id']) ||
    $_SESSION['role'] !== 'admin'
) {
    header("Location: ../login.php");
    exit();
}

$sql = "
    SELECT 
        a.*,
        u.email
    FROM audit_logs a
    LEFT JOIN users u
        ON a.user_id = u.id
    ORDER BY a.action_timestamp DESC
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audit Logs</title>
    <link rel="icon" href="../assets/image/alumni_plp_newicon.png" type="image/x-icon">
    <?php include('includes/global_styles.php'); ?>
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">

    <div class="app-wrapper">

        <?php
        include('includes/navbar.php');
        include('includes/sidebar.php');
        ?>

        <main class="app-main">

            <!-- HEADER -->
            <div class="app-content-header">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">Audit Logs</h3>
                        </div>

                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item">
                                    <a href="dashboard.php">Home</a>
                                </li>

                                <li class="breadcrumb-item active">
                                    Audit Logs
                                </li>
                            </ol>
                        </div>
                    </div>

                </div>
            </div>

            <!-- CONTENT -->
            <div class="app-content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                System Audit Trail
                            </h3>
                        </div>

                        <div class="card-body table-responsive">
                            <table class="table table-bordered table-hover" id="table-data">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Table</th>
                                        <th>Record ID</th>
                                        <th>Action</th>
                                        <th>Admin</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php if ($result && $result->num_rows > 0): ?>
                                        <?php while ($row = $result->fetch_assoc()): ?>
                                            <tr>
                                                <td><?= $row['log_id']; ?></td>
                                                <td><?= htmlspecialchars($row['table_name']); ?></td>
                                                <td><?= $row['record_id']; ?></td>
                                                <td>
                                                    <?php
                                                    $badge = 'secondary';

                                                    if ($row['action_type'] == 'INSERT') {
                                                        $badge = 'success';
                                                    }

                                                    if ($row['action_type'] == 'UPDATE') {
                                                        $badge = 'primary';
                                                    }

                                                    if ($row['action_type'] == 'DELETE') {
                                                        $badge = 'danger';
                                                    }
                                                    ?>
                                                    <span class="badge bg-<?= $badge; ?>"><?= $row['action_type']; ?></span>
                                                </td>

                                                <td><?= htmlspecialchars($row['email'] ?? 'Unknown'); ?></td>

                                                <td><?= date("M d, Y h:i A", strtotime($row['action_timestamp'])); ?></td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center">No audit logs found.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php include("includes/footer.php"); ?>
    </div>
</body>
</html>