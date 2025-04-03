<?php
include 'connection.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Fetch user from database
    $query = "SELECT id, username, password, fname, minitial, lname FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // Store user details in session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            // Construct full name and store in session
            $_SESSION['full_name'] = "{$user['fname']} " . (!empty($user['minitial']) ? "{$user['minitial']}. " : "") . "{$user['lname']}";

            $_SESSION['success_message'] = "Welcome, $username! You have successfully logged in.";
            header("Location: dashboard.php");
            exit();
        } else {
            $_SESSION['error_message'] = "Invalid password. Please try again!";
            header("Location: login.php");
            exit();
        }
    } else {
        $_SESSION['missing_message'] = "User not found!";
        header("Location: login.php");
        exit();
    }
}
?>
