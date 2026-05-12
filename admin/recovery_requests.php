<?php
include("../backend/db_admin.php");
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$message = $_SESSION['recovery_msg'] ?? "";
unset($_SESSION['recovery_msg']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recovery Requests | Alumni Association</title>
    <link rel="icon" href="../assets/image/alumni_plp_newicon.png" type="image/x-icon">
    <?php include('includes/global_styles.php'); ?>
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
                            <h3 class="mb-0">Recovery Requests</h3>
                        </div>

                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Recovery Requests</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="app-content">
                <div class="container-fluid">

                    <?php if ($message): ?>
                        <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
                    <?php endif; ?>

                    <div class="card">
                        <div class="card-body">

                            <?php
                            $stmt = $conn->prepare("
                                        SELECT r.id, r.reason, r.status, r.created_at, u.email
                                        FROM recovery_requests r
                                        JOIN users u ON u.id = r.user_id
                                        ORDER BY r.id DESC
                                    ");
                            $stmt->execute();
                            $result = $stmt->get_result();
                            ?>

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Email</th>
                                        <th>Reason</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php while ($row = $result->fetch_assoc()): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($row['email']) ?></td>
                                            <td><?= htmlspecialchars($row['reason']) ?></td>

                                            <td>
                                                <?php if ($row['status'] === 'pending'): ?>
                                                    <span style="color:orange;">Pending</span>
                                                <?php elseif ($row['status'] === 'approved'): ?>
                                                    <span style="color:green;">Approved</span>
                                                <?php else: ?>
                                                    <span style="color:red;">Rejected</span>
                                                <?php endif; ?>
                                            </td>

                                            <td><?= $row['created_at'] ?></td>

                                            <td>
                                                <?php if ($row['status'] === 'pending'): ?>

                                                    <form method="POST" action="recovery_action.php" style="display:inline;">
                                                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                                        <input type="hidden" name="action" value="approve">
                                                        <button class="btn btn-success btn-sm">Approve</button>
                                                    </form>

                                                    <form method="POST" action="recovery_action.php" style="display:inline;">
                                                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                                        <input type="hidden" name="action" value="reject">
                                                        <button class="btn btn-danger btn-sm">Reject</button>
                                                    </form>

                                                <?php else: ?>
                                                    <small>Done</small>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>

                            </table>

                        </div>
                    </div>

                </div>
            </div>

        </main>

        <?php include("includes/footer.php"); ?>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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