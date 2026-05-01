<?php
include("../backend/db_admin.php");
session_start();

/*
|--------------------------------------------------------------------------
| SESSION CHECK
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
| GET ALUMNI ID
|--------------------------------------------------------------------------
*/
if (!isset($_GET['id'])) {
    header("Location: all_alumni.php");
    exit();
}

$alumni_id = intval($_GET['id']);

/*
|--------------------------------------------------------------------------
| UPDATE ALUMNI
|--------------------------------------------------------------------------
*/
if (isset($_POST['update_alumni'])) {

    $first_name      = trim($_POST['first_name']);
    $middle_name     = trim($_POST['middle_name']);
    $last_name       = trim($_POST['last_name']);
    $email           = trim($_POST['email']);
    $contact_number  = trim($_POST['contact_number']);
    $student_number  = trim($_POST['student_number']);
    $course_id       = intval($_POST['course_id']);
    $year_graduated  = trim($_POST['year_graduated']);
    $address         = trim($_POST['address']);
    $suffix        = trim($_POST['suffix']);
    $birth_date    = trim($_POST['birthdate']);
    $sex           = trim($_POST['gender']);

    /*
    |--------------------------------------------------------------------------
    | VALIDATION
    |--------------------------------------------------------------------------
    */
    if (
        empty($first_name) ||
        empty($last_name) ||
        empty($email) ||
        empty($contact_number) ||
        empty($student_number) ||
        empty($course_id) ||
        empty($year_graduated)
    ) {

        $error = "Please fill in all required fields.";
    } else {

        /*
        |--------------------------------------------------------------------------
        | UPDATE QUERY
        |--------------------------------------------------------------------------
        */
        $query = "
                UPDATE users u

                INNER JOIN userprofile up
                    ON u.id = up.user_id

                INNER JOIN alumnidetails ad
                    ON u.id = ad.user_id

                SET
                    up.first_name = ?,
                    up.middle_name = ?,
                    up.last_name = ?,
                    up.contact_number = ?,
                    up.address = ?,
                    up.suffix = ?,
                    up.birthdate = ?,
                    up.gender = ?,
                    u.email = ?,
                    ad.student_number = ?,
                    ad.course_id = ?,
                    ad.year_graduated = ?

                WHERE ad.alumni_id = ?
            ";

        $stmt = $conn->prepare($query);

        $stmt->bind_param(
            "ssssssssssssi",
            $first_name,
            $middle_name,
            $last_name,
            $contact_number,
            $address,
            $suffix,
            $birth_date,
            $sex,
            $email,
            $student_number,
            $course_id,
            $year_graduated,
            $alumni_id
        );

        if ($stmt->execute()) {

            header("Location: all_alumni.php?update=success");
            exit();
        } else {

            $error = "Something went wrong. Please try again.";
        }
    }
}

/*
|--------------------------------------------------------------------------
| FETCH ALUMNI DETAILS
|--------------------------------------------------------------------------
*/
$query = "
    SELECT

        ad.alumni_id,
        ad.student_number,
        ad.course_id,
        ad.year_graduated,

        u.email,

        up.first_name,
        up.middle_name,
        up.last_name,
        up.contact_number,
        up.address,
        up.suffix,
        up.birthdate,
        up.gender

    FROM alumnidetails ad

    INNER JOIN users u
        ON ad.user_id = u.id

    INNER JOIN userprofile up
        ON ad.user_id = up.user_id

    WHERE ad.alumni_id = ?
";

$stmt = $conn->prepare($query);

$stmt->bind_param("i", $alumni_id);

$stmt->execute();

$result = $stmt->get_result();

$row = $result->fetch_assoc();

if (!$row) {
    header("Location: all_alumni.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Alumnus Details | Alumni Portal</title>
    <link rel="icon" href="../assets/image/alumni-logo.png" type="image/x-icon">
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
                <div class="app-content-header">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">
                                <h3 class="mb-0">Update Alumnus Details</h3>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-end">
                                    <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Update Alumnus Details</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CONTENT -->
                <div class="app-content">
                    <div class="container-fluid">
                        <div class="row g-4">
                            <div class="col-md-12">
                                <div class="card card-primary card-outline mb-4">
                                    <div class="card-header">
                                        <div class="card-title">Alumnus details are shown here</div>
                                    </div>
                                    <?php if (isset($error)) : ?>
                                        <div class="alert alert-danger m-3"><?php echo $error; ?></div>
                                    <?php endif; ?>
                                    <form method="POST">
                                        <div class="card-body">

                                            <!-- ROW 1: STUDENT NUMBER ONLY -->
                                            <div class="row g-3">
                                                <div class="col-md-3">
                                                    <label class="form-label">Student Number <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="student_number"
                                                        value="<?php echo htmlspecialchars($row['student_number']); ?>" readonly>
                                                </div>
                                            </div>

                                            <!-- ROW 2: NAME FIELDS -->
                                            <div class="row g-3 mt-2">
                                                <div class="col-md-3">
                                                    <label class="form-label">First Name</label>
                                                    <input type="text" class="form-control" name="first_name"
                                                        value="<?php echo htmlspecialchars($row['first_name']); ?>" required>
                                                </div>

                                                <div class="col-md-3">
                                                    <label class="form-label">Middle Name</label>
                                                    <input type="text" class="form-control" name="middle_name"
                                                        value="<?php echo htmlspecialchars($row['middle_name']); ?>">
                                                </div>

                                                <div class="col-md-3">
                                                    <label class="form-label">Last Name</label>
                                                    <input type="text" class="form-control" name="last_name"
                                                        value="<?php echo htmlspecialchars($row['last_name']); ?>" required>
                                                </div>

                                                <div class="col-md-3">
                                                    <label class="form-label">Suffix</label>
                                                    <select class="form-select" name="suffix">
                                                        <option value="" <?= empty($row['suffix']) ? 'selected' : '' ?>>None</option>
                                                        <option value="Jr." <?= ($row['suffix'] == 'Jr.') ? 'selected' : '' ?>>Jr.</option>
                                                        <option value="Sr." <?= ($row['suffix'] == 'Sr.') ? 'selected' : '' ?>>Sr.</option>
                                                        <option value="II" <?= ($row['suffix'] == 'II') ? 'selected' : '' ?>>II</option>
                                                        <option value="III" <?= ($row['suffix'] == 'III') ? 'selected' : '' ?>>III</option>
                                                        <option value="IV" <?= ($row['suffix'] == 'IV') ? 'selected' : '' ?>>IV</option>
                                                        <option value="V" <?= ($row['suffix'] == 'V') ? 'selected' : '' ?>>V</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- ROW 3: ADDRESS -->
                                            <div class="row g-3 mt-2">
                                                <div class="col-md-12">
                                                    <label class="form-label">Address <span class="text-danger">*</span></label>
                                                    <textarea class="form-control" name="address" rows="3"><?php echo htmlspecialchars($row['address']); ?></textarea>
                                                </div>
                                            </div>

                                            <!-- ROW 4: BIRTH + GENDER -->
                                            <div class="row g-3 mt-2">
                                                <div class="col-md-6">
                                                    <label class="form-label">Birth Date <span class="text-danger">*</span></label>
                                                    <input type="date" class="form-control" name="birthdate"
                                                        value="<?php echo htmlspecialchars($row['birthdate'] ?? ''); ?>">
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label d-block">Sex <span class="text-danger">*</span></label>

                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="gender" value="Male"
                                                            <?= ($row['gender'] == 'Male') ? 'checked' : '' ?>>
                                                        <label class="form-check-label">Male</label>
                                                    </div>

                                                    <div class="form-check form-check-inline sex__details">
                                                        <input class="form-check-input" type="radio" name="gender" value="Female"
                                                            <?= ($row['gender'] == 'Female') ? 'checked' : '' ?>>
                                                        <label class="form-check-label">Female</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- ROW 5: EMAIL + PHONE -->
                                            <div class="row g-3 mt-2">
                                                <div class="col-md-6">
                                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                                    <input type="email" class="form-control" name="email"
                                                        value="<?php echo htmlspecialchars($row['email']); ?>" required>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="contact_number"
                                                        maxlength="11"
                                                        value="<?php echo htmlspecialchars($row['contact_number']); ?>" required>
                                                </div>
                                            </div>

                                            <!-- ROW 6: COURSE + YEAR -->
                                            <div class="row g-3 mt-2">
                                                <div class="col-md-6">
                                                    <label class="form-label">Course <span class="text-danger">*</span></label>
                                                    <select class="form-select" name="course_id" required>
                                                        <option value="">Select a Course</option>
                                                        <?php
                                                        $courseQuery = "SELECT * FROM courses ORDER BY course_code ASC";
                                                        $courseResult = mysqli_query($conn, $courseQuery);
                                                        while ($course = mysqli_fetch_assoc($courseResult)) :
                                                        ?>
                                                            <option value="<?php echo $course['course_id']; ?>"
                                                                <?php if ($course['course_id'] == $row['course_id']) echo "selected"; ?>>
                                                                <?php echo $course['course_code']; ?>
                                                            </option>
                                                        <?php endwhile; ?>
                                                    </select>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">Year Graduated <span class="text-danger">*</span></label>
                                                    <input type="number" class="form-control" name="year_graduated"
                                                        value="<?php echo $row['year_graduated']; ?>" required>
                                                </div>
                                            </div>

                                        </div>
                                        <!-- FOOTER -->
                                        <div class="card-footer">
                                            <button class="btn btn-primary" name="update_alumni" type="submit"><i class="bi bi-floppy"></i>&nbsp; Save Changes</button>
                                            <a href="all_alumni.php" class="btn float-end"><i class="bi bi-arrow-left-circle"></i>&nbsp; Back to All Alumni</a>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/regis_script.js"></script>

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