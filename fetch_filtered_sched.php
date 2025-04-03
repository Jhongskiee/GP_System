<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'connection.php'; // Ensure database connection

$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];

$query = "SELECT equipdate, MAX(print_status) AS print_status 
          FROM equipsched 
          WHERE equipdate BETWEEN ? AND ? 
          GROUP BY equipdate 
          ORDER BY equipdate DESC";

$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $start_date, $end_date);
$stmt->execute();
$result = $stmt->get_result();

$output = "";
$count = 1;

while ($row = $result->fetch_assoc()) {
    $formatted_date = date("F d, Y", strtotime($row['equipdate']));
    $status = isset($row['print_status']) ? $row['print_status'] : 'Not Printed';

    $output .= "
        <tr>
            <td>{$count}</td>
            <td>{$formatted_date}</td>
            <td>{$status}</td>
            <td>
                <button class='btn btn-primary btn-sm view-details' data-date='{$row['equipdate']}'>View</button>
            </td>
        </tr>
    ";
    $count++;
}

echo $output;
?>
