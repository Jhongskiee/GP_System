<?php
session_start(); // Start the session
include 'connection.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Convert input values to uppercase before saving
    $vehitype = strtoupper(mysqli_real_escape_string($conn, $_POST['vehitype']));
    $vehibrand = strtoupper(mysqli_real_escape_string($conn, $_POST['vehibrand']));
    $vehicle = strtoupper(mysqli_real_escape_string($conn, $_POST['vehicle']));
    $vehiplate = strtoupper(mysqli_real_escape_string($conn, $_POST['vehiplate']));
    $vehicate = strtoupper(mysqli_real_escape_string($conn, $_POST['vehicate']));

    // Check if vehicle or plate number already exists
    $check_vehicle_query = "SELECT * FROM vehicle WHERE vehicle = '$vehicle'";
    $check_plate_query = "SELECT * FROM vehicle WHERE vehiplate = '$vehiplate'";

    $result_vehicle = mysqli_query($conn, $check_vehicle_query);
    $result_plate = mysqli_query($conn, $check_plate_query);

    if (mysqli_num_rows($result_vehicle) > 0) {
        $_SESSION['message'] = "VEHICLE '$vehicle' ALREADY EXISTS!";
        $_SESSION['status'] = "error";
    } elseif (mysqli_num_rows($result_plate) > 0) {
        $_SESSION['message'] = "PLATE # '$vehiplate' ALREADY EXISTS!";
        $_SESSION['status'] = "error";
    } else {
        // Insert new vehicle record
        $insert_query = "INSERT INTO vehicle (vehitype, vehibrand, vehicle, vehiplate, vehicate) VALUES ('$vehitype', '$vehibrand', '$vehicle', '$vehiplate', '$vehicate')";
        
        if (mysqli_query($conn, $insert_query)) {
            $_SESSION['message'] = "VEHICLE ADDED SUCCESSFULLY!";
            $_SESSION['status'] = "success";
        } else {
            $_SESSION['message'] = "FAILED TO ADD VEHICLE!";
            $_SESSION['status'] = "error";
        }
    }

    // Redirect to dashboard.php
    header("Location: dashboard.php");
    exit();
}
?>
