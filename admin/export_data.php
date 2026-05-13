<?php
include("../backend/db_admin.php");
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

if (isset($_POST['exportexcel'])) {

    $filename = "alumni_data_" . date("Y-m-d") . ".xls";

    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=\"$filename\"");

    $sql = "
    SELECT 
        ad.student_number,
        up.first_name,
        up.middle_name,
        up.last_name,
        up.suffix,
        u.email,
        up.contact_number AS phone,
        up.address,
        up.birthdate,
        up.gender AS sex,
        d.department_name AS department,
        c.course_code,
        ad.year_graduated
    FROM alumnidetails ad
    INNER JOIN users u ON ad.user_id = u.id
    INNER JOIN userprofile up ON up.user_id = u.id
    LEFT JOIN courses c ON ad.course_id = c.course_id
    LEFT JOIN departments d ON c.department_id = d.department_id
    ORDER BY ad.year_graduated DESC
";

    $result = mysqli_query($conn, $sql);

    // EXPORT HEADERS (MATCH IMPORT FORMAT)
    echo implode("\t", [
        "Student Number",
        "First Name",
        "Middle Name",
        "Surname",
        "Suffix",
        "Email",
        "Phone",
        "Address",
        "Birthdate",
        "Sex",
        "Department",
        "Course Code",
        "Year Graduated"
    ]) . "\n";

    // DATA ROWS
    while ($row = mysqli_fetch_assoc($result)) {

        echo implode("\t", [
            $row['student_number'],
            $row['first_name'],
            $row['middle_name'] ?? '',
            $row['last_name'],
            $row['suffix'] ?? '',
            $row['email'],
            $row['phone'],
            $row['address'] ?? '',
            $row['birthdate'] ?? '',
            $row['sex'] ?? '',
            $row['department'],
            $row['course_code'],
            $row['year_graduated']
        ]) . "\n";
    }

    exit();
}
