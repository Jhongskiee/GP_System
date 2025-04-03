<?php
include 'connection.php';

if (isset($_GET['schedDate'])) {
    $schedDate = $conn->real_escape_string($_GET['schedDate']);

    $query = "SELECT * FROM equipsched WHERE DATE(equipdate) = STR_TO_DATE('$schedDate', '%M %d, %Y')";
    $result = $conn->query($query);

    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    echo json_encode($data);
} else {
    echo json_encode([]); // Return an empty array if no date is set
}
?>
