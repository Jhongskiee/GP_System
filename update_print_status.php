<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['date'])) {
    $date = $_POST['date'];  // Date from AJAX (e.g., "April 03, 2025")

    // Convert to MySQL format (YYYY-MM-DD)
    $formattedDate = date("Y-m-d", strtotime($date));

    $stmt = $conn->prepare("UPDATE equipsched SET print_status = 'Printed' WHERE equipdate = ?");
    $stmt->bind_param("s", $formattedDate);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>
