<?php
include("../backend/db_admin.php");
session_start();

include("includes/flash.php");
/*
|-------------------------------------------------
| SESSION CHECK
|-------------------------------------------------
*/
if (
    !isset($_SESSION['user_id']) ||
    $_SESSION['role'] !== 'admin'
) {
    header("Location: ../login.php");
    exit();
}

$user_email = $_SESSION['user_email'];

/*
|-------------------------------------------------
| FETCH USER DATA
|-------------------------------------------------
*/
$sql = " SELECT id, email FROM users WHERE email = ? ";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_email);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>User Profile | Alumni Association</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/image/alumni_plp_newicon.png" type="image/x-icon">
    <?php include('includes/global_styles.php'); ?>

    <style>
        .table-responsive {
            padding: 4px;
            padding-top: 8px;
            margin-bottom: -14px;
        }

        .table-wrapper {
            min-width: 1000px;
            background: #fff;
            padding: 20px;
            box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
        }

        table.table tr th,
        table.table tr td {
            border-color: #e9e9e9;
            padding: 10px;
        }

        table.table td:last-child {
            width: auto;
        }
    </style>
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">

        <?php
        include('includes/navbar.php');
        include('includes/sidebar.php');
        ?>

        <main class="app-main">
            <div class="app-content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">User Profile</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">User Profile</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="app-content">
                <div class="container-fluid">
                    <div class="row g-4">
                        <div class="col-md-12">
                            <div class="card card-primary card-outline mb-4">
                                <div class="card-header">
                                    <div class="card-title">Welcome, Admin!</div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <?php if ($user): ?>
                                                    <div class="profile-info">
                                                        <tr>
                                                            <th>User ID</th>
                                                            <td><?php echo htmlspecialchars($user['id']); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Email</th>
                                                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                                                        </tr>
                                                    </div>
                                                <?php else: ?>
                                                    <p>User data not found.</p>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <a href="edit_profile.php" class="btn btn-primary"><i class="bi bi-pencil-square"></i>&nbsp; Edit Profile</a>
                                </div>
                            </div>
                            <?php if (isset($_GET['update']) && htmlspecialchars($_GET['update']) == 'success'): ?>
                                <div class="callout callout-success">Profile updated successfully!</div>
                            <?php endif; ?>
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