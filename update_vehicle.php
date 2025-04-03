<?php
session_start(); // Start the session
include 'connection.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $vehitype = strtoupper(mysqli_real_escape_string($conn, $_POST['vehitype']));
    $vehibrand = strtoupper(mysqli_real_escape_string($conn, $_POST['vehibrand']));
    $vehicle = strtoupper(mysqli_real_escape_string($conn, $_POST['vehicle']));
    $vehiplate = strtoupper(mysqli_real_escape_string($conn, $_POST['vehiplate']));
    $vehicate = strtoupper(mysqli_real_escape_string($conn, $_POST['vehicate']));

    // Check if the updated vehicle name OR plate number already exists for another record
    $check_query = "SELECT * FROM vehicle WHERE (vehicle = '$vehicle' OR vehiplate = '$vehiplate') AND id != '$id'";
    $result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if ($row['vehicle'] == $vehicle) {
            $_SESSION['message'] = "VEHICLE '$vehicle' ALREADY EXISTS!";
        } elseif ($row['vehiplate'] == $vehiplate) {
            $_SESSION['message'] = "PLATE # '$vehiplate' ALREADY EXISTS!";
        }
        $_SESSION['status'] = "error";
    } else {
        // Update the vehicle record
        $update_query = "UPDATE vehicle SET vehitype='$vehitype', vehibrand='$vehibrand', vehicle='$vehicle', vehiplate='$vehiplate', vehicate='$vehicate' WHERE id='$id'";

        if (mysqli_query($conn, $update_query)) {
            $_SESSION['message'] = "VEHICLE UPDATED SUCCESSFULLY!";
            $_SESSION['status'] = "success";
        } else {
            $_SESSION['message'] = "FAILED TO UPDATE VEHICLE!";
            $_SESSION['status'] = "error";
        }
    }

    // Redirect to dashboard.php
    header("Location: dashboard.php");
    exit();
}
?>
