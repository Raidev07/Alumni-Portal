<?php
include "db.php";

$student_id = $_POST['studentId'];
$first_name = $_POST['firstName'];
$middle_name = $_POST['middleName'];
$last_name = $_POST['lastName'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

// detect role
if (isset($_POST['yearLevel'])) {
    $role = "student";
} else {
    $role = "alumni";
}

$sql = "INSERT INTO users 
(student_id, first_name, middle_name, last_name, email, password, role)
VALUES 
('$student_id','$first_name','$middle_name','$last_name','$email','$password','$role')";

if ($conn->query($sql) === TRUE) {
    header("Location: ../login.php");
} else {
    echo "Error: " . $conn->error;
}
?>