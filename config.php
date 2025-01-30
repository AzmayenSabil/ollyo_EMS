<?php
$host = "localhost";
$dbname = "event_management";
$username = "root";
$password = "admin";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
