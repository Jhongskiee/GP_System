<?php
include 'connection.php';

if (isset($_POST['id'])) {
    $id = $conn->real_escape_string($_POST['id']);
    $equipoperator = $conn->real_escape_string($_POST['equipoperator']);
    $equiptype = $conn->real_escape_string($_POST['equiptype']);
    $equipbrand = $conn->real_escape_string($_POST['equipbrand']);
    $equipplate = $conn->real_escape_string($_POST['equipplate']);
    $equiparea = $conn->real_escape_string($_POST['equiparea']);
    $equipnature = $conn->real_escape_string($_POST['equipnature']);

    $query = "UPDATE equipsched 
              SET equipoperator='$equipoperator', equiptype='$equiptype', equipbrand='$equipbrand', 
                  equipplate='$equipplate', equiparea='$equiparea', equipnature='$equipnature' 
              WHERE id='$id'";

    if ($conn->query($query)) {
        echo "Success";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
