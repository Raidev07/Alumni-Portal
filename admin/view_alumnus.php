<?php
session_start();
include("../backend/db_admin.php");

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

/*
|-------------------------------------------------
| VALIDATE ID
|-------------------------------------------------
*/
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: all_alumni.php");
    exit();
}

$vid = (int) $_GET['id'];

/*
|-------------------------------------------------
| FETCH ALUMNI DETAILS (SAFE)
|-------------------------------------------------
*/
$sql = "
    SELECT 
    u.id,
    u.email,
    p.first_name,
    p.last_name,
    p.middle_name,
    p.contact_number,
    p.address,
    p.gender,
    a.student_number,
    a.year_graduated,
    c.course_name
FROM alumnidetails a
INNER JOIN users u ON a.user_id = u.id
LEFT JOIN userprofile p ON p.user_id = u.id
LEFT JOIN courses c ON a.course_id = c.course_id
WHERE a.alumni_id = ?
LIMIT 1
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $vid);
$stmt->execute();

$result = $stmt->get_result();
$row = $result->fetch_assoc();

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumnus Details | Alumni Association</title>
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
                            <h3 class="mb-0">Alumnus Details</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Alumnus Details</li>
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
                                    <div class="card-title">Alumnus details are shown here</div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <?php if ($row): ?>

                                                    <tr>
                                                        <th>Member ID</th>
                                                        <td><?php echo $row['id']; ?></td>
                                                        <th>Full Name</th>
                                                        <td><?php echo trim($row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name']); ?></td>
                                                    </tr>

                                                    <tr>
                                                        <th>Email</th>
                                                        <td><?php echo $row['email']; ?></td>
                                                        <th>Phone Number</th>
                                                        <td><?php echo $row['contact_number']; ?></td>
                                                    </tr>

                                                    <tr>
                                                        <th>Student Number</th>
                                                        <td><?php echo $row['student_number']; ?></td>
                                                        <th>Course</th>
                                                        <td><?php echo $row['course_name']; ?></td>
                                                    </tr>

                                                    <tr>
                                                        <th>Year Graduated</th>
                                                        <td><?php echo $row['year_graduated']; ?></td>
                                                        <th>Gender</th>
                                                        <td><?php echo $row['gender']; ?></td>
                                                    </tr>

                                                    <tr>
                                                        <th>Address</th>
                                                        <td colspan="3"><?php echo $row['address']; ?></td>
                                                    </tr>

                                                <?php else: ?>
                                                    <tr>
                                                        <td colspan="4">No alumni data found.</td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <a href="all_alumni.php" class="btn btn-primary"><i class="bi bi-arrow-left-circle"></i>&nbsp; Back to All Alumni</a>
                                </div>
                            </div>
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
</body>

</html>