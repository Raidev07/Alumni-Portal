<?php
$conn = new mysqli("localhost", "root", "", "AlumniDB");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>