<?php
include("../backend/db_admin.php");
session_start();

include("includes/flash.php");

// ADMIN CHECK
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// RESTORE ALUMNI (FIXED)
if (isset($_GET['restore_id'])) {

    $rid = intval($_GET['restore_id']);

    // GET USER ID (SAFE VERSION WITHOUT get_result)
    $stmt = $conn->prepare("
        SELECT user_id 
        FROM alumnidetails 
        WHERE alumni_id = ?
        LIMIT 1
    ");

    $stmt->bind_param("i", $rid);
    $stmt->execute();
    $stmt->bind_result($user_id);
    $stmt->fetch();
    $stmt->close();

    $user_id = $user_id ?? 0;

    // UNARCHIVE
    $stmt = $conn->prepare("
        UPDATE alumnidetails 
        SET is_archived = 0 
        WHERE alumni_id = ?
    ");
    $stmt->bind_param("i", $rid);
    $stmt->execute();
    $stmt->close();

    // RESTORE USER
    if ($user_id) {
        $stmt = $conn->prepare("
            UPDATE users 
            SET status = 'active'
            WHERE id = ?
        ");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->close();
    }

    // USE FLASH (IMPORTANT)
    flash("success", "Restored", "Alumnus restored successfully!");

    header("Location: archived_alumni.php");
    exit();
}

// FETCH ARCHIVED DATA
$query = "
SELECT
ad.alumni_id,

TRIM(CONCAT_WS(' ',
    up.first_name,
    NULLIF(up.middle_name, ''),
    up.last_name,
    NULLIF(up.suffix, '')
)) AS full_name,

c.course_code AS Programme,
ad.year_graduated AS Academic_year,
u.email AS Email,
up.contact_number AS Phone,
u.status AS Status

FROM alumnidetails ad
INNER JOIN users u ON ad.user_id = u.id
INNER JOIN userprofile up ON up.user_id = u.id
LEFT JOIN courses c ON ad.course_id = c.course_id

WHERE ad.is_archived = 1

ORDER BY ad.year_graduated DESC
";

$ret = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archived Alumni | Alumni Association</title>
    <link rel="icon" href="../assets/image/alumni_plp_newicon.png" type="image/x-icon">

    <?php include('includes/global_styles.php'); ?>

    <style>
        .badge-archived {
            background: #6c757d;
            color: #fff;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
        }

        .table td,
        .table th {
            vertical-align: middle;
        }

        .action-btn {
            padding: 5px 10px;
            border-radius: 6px;
            font-size: 12px;
            text-decoration: none;
            display: inline-block;
        }

        .btn-restore {
            background: #198754;
            color: #fff;
        }

        .btn-restore:hover {
            background: #157347;
            color: #fff;
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
                            <h3 class="mb-0">Archived Alumni</h3>
                        </div>

                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="all_alumni.php">All Alumni</a></li>
                                <li class="breadcrumb-item active">Archived Alumni</li>
                            </ol>
                            <?php if (isset($_GET['msg']) && $_GET['msg'] == 'restored'): ?>
                                <div class="alert alert-success mt-2">
                                    Alumnus restored successfully!
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CONTENT -->
            <div class="app-content">
                <div class="container-fluid">
                    <div class="card card-outline card-secondary">
                        <div class="card-header">
                            <div class="card-title">
                                Archived Alumni
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="table-data">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Program</th>
                                            <th>Year</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($ret && mysqli_num_rows($ret) > 0): ?>
                                            <?php $i = 1;
                                            while ($row = mysqli_fetch_assoc($ret)): ?>
                                                <tr>
                                                    <td><?= $i++ ?></td>
                                                    <td><?= htmlspecialchars($row['full_name']) ?></td>
                                                    <td><?= $row['Programme'] ?></td>
                                                    <td><?= $row['Academic_year'] ?></td>
                                                    <td><?= $row['Email'] ?></td>
                                                    <td><?= $row['Phone'] ?></td>
                                                    <td><span class="badge badge-archived">Archived</span></td>

                                                    <td>
                                                        <a href="archived_alumni.php?restore_id=<?= $row['alumni_id'] ?>"
                                                            class="action-btn btn-restore"
                                                            onclick="return confirm('Restore this alumnus?');">
                                                            Restore
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endwhile; ?>
                                        <?php else: ?>

                                            <tr>
                                                <td colspan="8" class="text-center text-danger">No archived records found.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
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