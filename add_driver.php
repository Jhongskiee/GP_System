<?php
session_start(); // Start the session
include 'connection.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Convert input values to uppercase before saving
    $fullname = strtoupper(mysqli_real_escape_string($conn, $_POST['fullname']));

    // Check if name already exists
    $check_driver_query = "SELECT * FROM driver WHERE fullname = '$fullname'";

    $result_driver = mysqli_query($conn, $check_driver_query);

    if (mysqli_num_rows($result_driver) > 0) {
        $_SESSION['message'] = "Driver: '$fullname' ALREADY EXISTS!";
        $_SESSION['status'] = "error";
    }else {
        // Insert new driver record
        $insert_query = "INSERT INTO driver (fullname) VALUES ('$fullname')";
        
        if (mysqli_query($conn, $insert_query)) {
            $_SESSION['message'] = "DRIVER ADDED SUCCESSFULLY!";
            $_SESSION['status'] = "success";
        } else {
            $_SESSION['message'] = "FAILED TO ADD DRIVER!";
            $_SESSION['status'] = "error";
        }
    }

    // Redirect to dashboard.php
    header("Location: dashboard.php");
    exit();
}
?>
