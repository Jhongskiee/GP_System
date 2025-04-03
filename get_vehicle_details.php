<?php
include 'connection.php';

if (isset($_POST['id'])) {
    $id = intval($_POST['id']); // Sanitize input

    $query = "SELECT vehitype, vehibrand FROM vehicle WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo json_encode(["success" => true, "vehitype" => $row['vehitype'], "vehibrand" => $row['vehibrand']]);
    } else {
        echo json_encode(["success" => false]);
    }

    $stmt->close();
    $conn->close();
}
?>
