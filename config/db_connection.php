<?php
$host = "localhost";
$username = "root";
$password = "Akosijeff12!"; 
$database = "enrollment_db";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
?>
