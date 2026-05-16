<?php
include("../backend/db_admin.php");
session_start();

// SESSION CHECK (ADMIN ONLY)
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// LIBRARIES
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

// MESSAGE
$success = "";
$error = "";

// IMPORT PROCESS
if (isset($_POST['import'])) {

    if (!isset($_FILES['file']['tmp_name'])) {
        $error = "Please upload a valid Excel file.";
    } else {

        $file = $_FILES['file']['tmp_name'];

        try {

            $spreadsheet = IOFactory::load($file);
            $rows = $spreadsheet->getActiveSheet()->toArray();

            $successCount = 0;
            $failCount = 0;

            foreach ($rows as $index => $row) {

                if ($index == 0) continue; // skip header

                /*
                |--------------------------------------------------------------------------
                | MAPPING (BASED SA FORMAT MO)
                |--------------------------------------------------------------------------
                | 0 School Number
                | 1 First Name
                | 2 Middle Name
                | 3 Surname
                | 4 Suffix
                | 5 Email
                | 6 Phone
                | 7 Address
                | 8 Birthdate
                | 9 Sex
                | 10 Department
                | 11 Course Code
                | 12 Year Graduated
                */

                $student_number = trim($row[0] ?? '');
                $first_name     = trim($row[1] ?? '');
                $middle_name    = trim($row[2] ?? '');
                $last_name      = trim($row[3] ?? '');
                $suffix         = trim($row[4] ?? '');
                $email          = trim($row[5] ?? '');
                $phone          = trim($row[6] ?? '');
                $address        = trim($row[7] ?? '');
                $birthdate      = trim($row[8] ?? '');
                $sex            = trim($row[9] ?? '');
                $department     = trim($row[10] ?? '');
                $course_code    = trim($row[11] ?? '');
                $year_graduated = trim($row[12] ?? '');

                if (!$student_number || !$email || !$course_code) {
                    $failCount++;
                    continue;
                }

                // CHECK DUPLICATE EMAIL
                $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
                $check->bind_param("s", $email);
                $check->execute();

                if ($check->get_result()->num_rows > 0) {
                    $failCount++;
                    continue;
                }

                // GET DEPARTMENT
                $stmt = $conn->prepare("SELECT department_id FROM departments WHERE department_name = ?");
                $stmt->bind_param("s", $department);
                $stmt->execute();
                $dept = $stmt->get_result()->fetch_assoc();

                if (!$dept) {
                    $failCount++;
                    continue;
                }

                // GET COURSE
                $stmt = $conn->prepare("
                    SELECT course_id 
                    FROM courses 
                    WHERE course_code = ? 
                    AND department_id = ?
                ");
                $stmt->bind_param("si", $course_code, $dept['department_id']);
                $stmt->execute();
                $course = $stmt->get_result()->fetch_assoc();

                if (!$course) {
                    $failCount++;
                    continue;
                }

                // AUTO PASSWORD
                $plainPassword = $student_number . "_" . strtolower($last_name);
                $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

                // INSERT USER
                $stmt = $conn->prepare("
                    INSERT INTO users (email, password, role, status)
                    VALUES (?, ?, 'alumni', 'active')
                ");
                $stmt->bind_param("ss", $email, $hashedPassword);
                $stmt->execute();

                $user_id = $stmt->insert_id;

                // INSERT PROFILE
                $stmt = $conn->prepare("
                    INSERT INTO userprofile
                    (user_id, first_name, middle_name, last_name, suffix, contact_number, address, birthdate, gender)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
                ");
                $stmt->bind_param(
                    "issssssss",
                    $user_id,
                    $first_name,
                    $middle_name,
                    $last_name,
                    $suffix,
                    $phone,
                    $address,
                    $birthdate,
                    $sex
                );
                $stmt->execute();

                // INSERT ALUMNI DETAILS
                $stmt = $conn->prepare("
                    INSERT INTO alumnidetails
                    (user_id, student_number, course_id, year_graduated)
                    VALUES (?, ?, ?, ?)
                ");
                $stmt->bind_param(
                    "isis",
                    $user_id,
                    $student_number,
                    $course['course_id'],
                    $year_graduated
                );
                $stmt->execute();

                $successCount++;
            }

            $success = "Import completed. Success: $successCount | Failed: $failCount";
        } catch (Exception $e) {
            $error = "Import failed: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import Alumni| Alumni Association</title>
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
                            <h3 class="mb-0">Import Alumni</h3>
                        </div>

                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Import Alumni</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container mt-4">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h4>Import Alumni (Excel)</h4>
                    </div>

                    <div class="card-body">
                        <?php if ($success): ?>
                            <div class="alert alert-success"><?= $success ?></div>
                        <?php endif; ?>

                        <?php if ($error): ?>
                            <div class="alert alert-danger"><?= $error ?></div>
                        <?php endif; ?>

                        <form method="POST" enctype="multipart/form-data">
                            <input type="file" name="file" class="form-control mb-3" required>
                            <button class="btn btn-primary" name="import">Import</button>
                        </form>
                        <hr>
                        <h5>Excel Format Required:</h5>
                        <pre>School Number | First Name | Middle Name | Surname | Suffix | Email | Phone | Address | Birthdate | Sex | Department | Course Code | Year Graduated</pre>
                        <a href="download_import_template.php" class="btn btn-success mt-2">
                            <i class="bi bi-download"></i> Download Template
                        </a>
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