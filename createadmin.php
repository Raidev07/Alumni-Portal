<?php
include "backend/db_admin.php";

$email = "admin@plpasig.com";
$password = password_hash("admin123", PASSWORD_DEFAULT);
$role = "admin";

$stmt = $conn->prepare("INSERT INTO users (email, password, role) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $email, $password, $role);
$stmt->execute();

echo "Admin created successfully!";
?>
