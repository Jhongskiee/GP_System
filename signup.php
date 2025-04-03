<?php
include 'connection.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $fname = trim($_POST['fname']);
    $minitial = trim($_POST['minitial']);
    $lname = trim($_POST['lname']);
    
    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Check if username already exists
    $checkQuery = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("s", $username); // Fix: Only binding the username
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['error_message'] = "Account already exists";
        header("Location: login.php");
        exit();
    } else {
        // Insert user into database
        $query = "INSERT INTO users (username, password, fname, minitial, lname) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssss", $username, $hashed_password, $fname, $minitial, $lname); // Fix: Now binding all 5 parameters
        
        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Account successfully Registered";
            header("Location: login.php");
            exit();
        } else {
            $_SESSION['error_message'] = "Error: " . $stmt->error;
            header("Location: login.php");
            exit();
        }
    }
}
?>
