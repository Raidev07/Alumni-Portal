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
| EXPORT PROCESS
|--------------------------------------------------------------------------
*/
if (isset($_POST['exportexcel'])) {

    $filename = "alumni_data_" . date("Y-m-d") . ".xls";

    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=\"$filename\"");

    /*
    |--------------------------------------------------------------------------
    | CORRECT QUERY (BASED SA DB MO)
    |--------------------------------------------------------------------------
    */
    $sql = "
        SELECT 
            up.first_name,
            up.last_name,
            u.email,
            up.contact_number AS phone,
            c.course_code AS course,
            ad.year_graduated
        FROM alumnidetails ad
        INNER JOIN users u ON ad.user_id = u.id
        INNER JOIN userprofile up ON up.user_id = u.id
        LEFT JOIN courses c ON ad.course_id = c.course_id
        ORDER BY up.last_name ASC
    ";

    $result = mysqli_query($conn, $sql);

    /*
    |--------------------------------------------------------------------------
    | HEADERS
    |--------------------------------------------------------------------------
    */
    echo implode("\t", [
        "First Name",
        "Last Name",
        "Email",
        "Phone",
        "Course",
        "Year Graduated"
    ]) . "\n";

    /*
    |--------------------------------------------------------------------------
    | DATA ROWS
    |--------------------------------------------------------------------------
    */
    while ($row = mysqli_fetch_assoc($result)) {

        echo implode("\t", [
            $row['first_name'],
            $row['last_name'],
            $row['email'],
            $row['phone'],
            $row['course'],
            $row['year_graduated']
        ]) . "\n";
    }

    exit();
}
?>