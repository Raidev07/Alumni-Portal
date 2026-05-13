<?php
include("../backend/db_admin.php");
session_start();

include("includes/flash.php");
/* =========================
   AUTH CHECK
========================= */
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

/* =========================
   PHPMailer LOAD
========================= */
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
require '../PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/* =========================
    MESSAGES
========================= */

$error = "";
$success = "";

/* =========================
    PASSWORD GENERATOR
========================= */
function generatePassword($length = 10)
{
    return substr(str_shuffle("ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789"), 0, $length);
}

/* =========================
    SUBMIT FORM
========================= */
if (isset($_POST['add_alumni'])) {

    // EMAIL
    $email = trim($_POST['email']);

    // PROFILE
    $first_name  = trim($_POST['first_name']);
    $middle_name = trim($_POST['middle_name']);
    $last_name   = trim($_POST['last_name']);
    $suffix      = trim($_POST['suffix']);
    $address     = trim($_POST['address']);
    $birthdate   = $_POST['birthdate'];
    $gender      = $_POST['gender'];
    $phone       = trim($_POST['phone']);

    // ALUMNI DETAILS
    $student_number = trim($_POST['student_number']);
    $course_id      = intval($_POST['course_id']);
    $year_graduated = intval($_POST['year_graduated']);

    // AUTO PASSWORD
    $password_plain  = $student_number . "_" . $last_name;
    $password_hashed = password_hash($password_plain, PASSWORD_BCRYPT);

    // VALIDATION
    if (
        empty($email) ||
        empty($first_name) ||
        empty($last_name) ||
        empty($student_number) ||
        empty($course_id) ||
        empty($year_graduated)
    ) {
        $error = "Please fill in all required fields.";
    } else {

        // USERS
        $stmt = $conn->prepare("INSERT INTO users (email, password, role) VALUES (?, ?, 'alumni')");
        $stmt->bind_param("ss", $email, $password_hashed);
        $stmt->execute();

        $user_id = $stmt->insert_id;

        // PROFILE
        $stmt = $conn->prepare("
            INSERT INTO userprofile
            (user_id, first_name, last_name, suffix, middle_name, contact_number, address, birthdate, gender)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->bind_param(
            "issssssss",
            $user_id,
            $first_name,
            $last_name,
            $suffix,
            $middle_name,
            $phone,
            $address,
            $birthdate,
            $gender
        );

        $stmt->execute();

        // ALUMNI DETAILS
        $stmt = $conn->prepare("
            INSERT INTO alumnidetails
            (user_id, student_number, course_id, year_graduated)
            VALUES (?, ?, ?, ?)
        ");

        $stmt->bind_param(
            "isis",
            $user_id,
            $student_number,
            $course_id,
            $year_graduated
        );

        if ($stmt->execute()) {

            /* =========================
                SEND EMAIL VIA SMTP
            ========================= */
            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;

                $mail->Username = 'pohlovesyou@gmail.com';
                $mail->Password = 'gieoihygssbcbtvh';

                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('pohlovesyou@gmail.com', 'Alumni System');
                $mail->addAddress($email, $first_name . ' ' . $last_name);

                $mail->isHTML(true);
                $mail->Subject = "Your Alumni Account Password";

                $mail->Body = "
                    <div style='font-family: Arial, sans-serif; background:#f4f6f9; padding:20px;'>
                        <div style='max-width:600px; margin:auto; background:white; border-radius:10px; overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,0.1);'>

                            <div style='background:#0d6efd; padding:20px; text-align:center; color:white;'>
                                <h2 style='margin:0;'>Alumni System</h2>
                            </div>

                            <div style='padding:30px; color:#333;'>
                                <h3 style='margin-top:0;'>Welcome, $first_name $last_name 👋</h3>

                                <p>Your account has been successfully created.</p>

                                <div style='background:#f8f9fa; padding:15px; border-radius:8px; margin:20px 0;'>
                                    <p style='margin:5px 0;'><b>Email:</b> $email</p>
                                    <p style='margin:5px 0;'><b>Password:</b> $password_plain</p>
                                </div>

                                <p style='color:#dc3545; font-weight:bold;'>
                                    ⚠ Please change your password immediately after login.
                                </p>

                                <a href='http://localhost/MAIN-PROJECT/Alumni-Portal/login.php' style='display:inline-block; margin-top:15px; padding:10px 20px; background:#0d6efd; color:white; text-decoration:none; border-radius:5px;'>
                                    Login Now
                                </a>
                            </div>

                            <div style='background:#f1f1f1; text-align:center; padding:15px; font-size:12px; color:#777;'>
                                © " . date('Y') . " Alumni System. All rights reserved.
                            </div>

                        </div>
                    </div>
                    ";

                $mail->send();

                $success = "Alumni added successfully! Email sent.";
            } catch (Exception $e) {
                $error = "Email failed: " . $mail->ErrorInfo;
            }
        } else {
            $error = "Failed to save alumni record.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Add Alumnus | Alumni Association</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                            <h3 class="mb-0">Add Alumnus</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Add Alumnus</li>
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
                                    <div class="card-title">Add a new alumnus here</div>
                                </div>
                                <form method="POST">
                                    <div class="card-body">

                                        <!-- ROW 1: STUDENT ID ONLY -->
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <label>Student ID <span class="text-danger">*</span></label>
                                                <input type="text" name="student_number" placeholder="24-00123"
                                                    class="form-control" pattern="\d{2}-\d{5}" required>
                                            </div>
                                        </div>

                                        <hr>

                                        <!-- ROW 2: PERSONAL INFO -->
                                        <div class="row g-3">

                                            <div class="col-md-4">
                                                <label>First Name <span class="text-danger">*</span></label>
                                                <input type="text" name="first_name" class="form-control" required>
                                            </div>

                                            <div class="col-md-4">
                                                <label>Middle Name</label>
                                                <input type="text" name="middle_name" class="form-control">
                                            </div>

                                            <div class="col-md-4">
                                                <label>Last Name <span class="text-danger">*</span></label>
                                                <input type="text" name="last_name" class="form-control" required>
                                            </div>

                                            <div class="col-md-4">
                                                <label>Suffix</label>
                                                <select name="suffix" class="form-select">
                                                    <option value="">None</option>
                                                    <option value="Jr">Jr</option>
                                                    <option value="Sr">Sr</option>
                                                    <option value="II">II</option>
                                                    <option value="III">III</option>
                                                    <option value="IV">IV</option>
                                                    <option value="V">V</option>
                                                </select>
                                            </div>

                                            <div class="col-md-4">
                                                <label>Email <span class="text-danger">*</span></label>
                                                <input type="email" name="email" class="form-control" required>
                                            </div>

                                            <div class="col-md-4">
                                                <label>Phone Number <span class="text-danger">*</span></label>
                                                <input type="text" name="phone" class="form-control">
                                            </div>

                                            <div class="col-md-6">
                                                <label>Address <span class="text-danger">*</span></label>
                                                <input type="text" name="address" class="form-control">
                                            </div>

                                            <div class="col-md-6">
                                                <label>Birth Date <span class="text-danger">*</span></label>
                                                <input type="date" name="birthdate" class="form-control">
                                            </div>

                                            <div class="col-md-6 sex__details">
                                                <label>Sex <span class="text-danger">*</span></label><br>
                                                <input type="radio" name="gender" value="Male"> Male
                                                <input type="radio" name="gender" value="Female"> Female
                                            </div>

                                        </div>

                                        <hr>

                                        <!-- ROW 3: SCHOOL INFO -->
                                        <div class="row g-3">

                                            <div class="col-md-6">
                                                <label>Program <span class="text-danger">*</span></label>
                                                <select name="course_id" class="form-select" required>
                                                    <option value="">Select Course</option>
                                                    <?php
                                                    $q = mysqli_query($conn, "SELECT * FROM courses");
                                                    while ($c = mysqli_fetch_assoc($q)) {
                                                        echo "<option value='{$c['course_id']}'>{$c['course_code']}</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label>Year Graduated <span class="text-danger">*</span></label>
                                                <input type="number" name="year_graduated" class="form-control" required>
                                            </div>

                                        </div>

                                    </div>
                                    <div class="card-footer">
                                        <button class="btn btn-primary" name="add_alumni" type="submit"><i class="bi bi-plus-circle"></i>&nbsp; Add Alumnus</button>
                                        <a href="all_alumni.php" class="btn float-end"><i class="bi bi-eye"></i>&nbsp; View All Alumni</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </main>

        <?php include("includes/footer.php"); ?>

    </div>

    <?php include("includes/flash-swal.php"); ?>

    <script src="js/regis_script.js"></script>    
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