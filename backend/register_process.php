<?php
include "db.php";

// ─── 1. Collect & sanitize POST data ────────────────────────────────────────

$student_number  = trim($_POST['studentId']     ?? '');
$first_name      = trim($_POST['firstName']     ?? '');
$middle_name     = trim($_POST['middleName']    ?? '');
$last_name       = trim($_POST['lastName']      ?? '');
$suffix          = trim($_POST['suffix']        ?? '');
$address         = trim($_POST['address']       ?? '');
$birthdate       = trim($_POST['birthdate']     ?? '');
$sex             = trim($_POST['sex']           ?? '');
$email           = trim($_POST['email']         ?? '');
$contact_number  = trim($_POST['contactNum']    ?? '');
$course_id       = (int)($_POST['course']       ?? 0);
$year_graduated  = (int)($_POST['yearEnrolled'] ?? 0);
$raw_password    = $_POST['password']           ?? '';
$confirm_pass    = $_POST['confirmPassword']    ?? '';

// detect role
if (isset($_POST['yearLevel'])) {
    $role = "student";
} else {
    $role = "alumni";
}

// ─── 2. Basic server-side validation ────────────────────────────────────────

$errors = [];

if (empty($student_number) || !preg_match('/^\d{2}-\d{5}$/', $student_number))
    $errors[] = "Invalid School ID format (e.g. 24-00123).";

if (empty($first_name))   $errors[] = "First name is required.";
if (empty($last_name))    $errors[] = "Last name is required.";
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL))
    $errors[] = "A valid email address is required.";

if (empty($contact_number) || !preg_match('/^09\d{9}$/', $contact_number))
    $errors[] = "Phone number must be 11 digits and start with 09.";

if ($course_id <= 0)      $errors[] = "Please select a course.";
if ($year_graduated <= 0) $errors[] = "Please select a graduation year.";

if (empty($raw_password) || $raw_password !== $confirm_pass)
    $errors[] = "Passwords do not match.";

if (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&*()_+\-=\[\]{};\':"\\|,.<>\/?]).{8,20}$/', $raw_password))
    $errors[] = "Password does not meet the requirements.";

$gender_map = ['male' => 'Male', 'female' => 'Female'];
$gender = $gender_map[strtolower($sex)] ?? null;
if ($gender === null) $errors[] = "Please select a sex.";

if (!empty($errors)) {
    session_start();
    $_SESSION['reg_errors'] = $errors;
    $_SESSION['reg_old']    = $_POST;
    header("Location: ../alumni_form.php");
    exit;
}
// Ni Comment ko kasi d ako sure if tatanggalin gumawa na kasi ng stored procedure si Sam (May delete on the future)
// $sql = "INSERT INTO users 
// (student_id, first_name, middle_name, last_name, email, password, role)
// VALUES 
// ('$student_id','$first_name','$middle_name','$last_name','$email','$password','$role')";

// ─── 3. Hash the password ────────────────────────────────────────────────────

$hashed_password = password_hash($raw_password, PASSWORD_DEFAULT);

// ─── 4. Call the stored procedure ───────────────────────────────────────────

$stmt = $conn->prepare(
    "CALL sp_RegisterAlumni(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
);

if (!$stmt) {
    error_log("Prepare failed: " . $conn->error);
    die("A system error occurred. Please try again later.");
}

$stmt->bind_param(
    "sssssssssssii",
    $email,
    $hashed_password,
    $first_name,
    $last_name,
    $suffix,
    $middle_name,
    $contact_number,
    $address,
    $birthdate,
    $gender,
    $student_number,
    $course_id,
    $year_graduated
);






// ─── 5. Execute & handle errors ─────────────────────────────────────────────

if ($stmt->execute()) {
    $stmt->close();
    $conn->close();
    header("Location: ../login.php?registered=1");
    exit;
} else {
    $errno    = $stmt->errno;
    $db_error = $stmt->error;
    $stmt->close();
    $conn->close();

    session_start();

    if ($errno === 1062) {
        if (stripos($db_error, 'email') !== false) {
            $_SESSION['reg_errors'] = ["An account with that email address already exists."];
        } elseif (stripos($db_error, 'student_number') !== false) {
            $_SESSION['reg_errors'] = ["An account with that School ID already exists."];
        } else {
            $_SESSION['reg_errors'] = ["That account already exists. Please log in instead."];
        }
    } else {
        error_log("sp_RegisterAlumni failed [$errno]: $db_error");
        $_SESSION['reg_errors'] = ["Registration failed due to a server error. Please try again."];
    }

    $_SESSION['reg_old'] = $_POST;
    header("Location: ../alumni_form.php");
    exit;
}

// if ($conn->query($sql) === TRUE) {
//     header("Location: ../login.php");
// } else {
//     echo "Error: " . $conn->error;
// }
?>




