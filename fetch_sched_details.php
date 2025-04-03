<?php
include 'connection.php';

if (isset($_POST['date'])) {
    $date = $conn->real_escape_string($_POST['date']);

    $query = "SELECT * FROM equipsched WHERE equipdate = '$date'";
    $result = $conn->query($query);

    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    echo json_encode($data);
}
?>
