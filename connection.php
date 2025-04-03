<?php
$host = "localhost"; // Change if using a different host
$user = "root"; // Change to your database username
$password = ""; // Change to your database password
$dbname = "gp_system"; // Your database name

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>