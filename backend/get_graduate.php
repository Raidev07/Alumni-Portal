<?php

include "db.php";

header('Content-Type: application/json');
$student_number = trim($_GET['student_number'] ?? '');
if (empty($student_number)) {
    echo json_encode([
        'success' => false,
        'message' => 'Student number is required.'  
    ]);
    exit;
}

$stmt = $conn->prepare("
    SELECT 
        first_name,
        middle_name,
        last_name,
        suffix,
        birthdate,
        gender,
        course_id,
        year_graduated
    FROM graduates
    WHERE student_number = ?
");

$stmt->bind_param("s", $student_number);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows === 0) {

    echo json_encode([
        'success' => false,
        'message' => 'Student number not found in graduates records.'
    ]);

} else {

    $graduate = $result->fetch_assoc();

    echo json_encode([
        'success' => true,
        'data' => $graduate
    ]);
}

$stmt->close();
$conn->close();
?>