<?php
file_put_contents('debug.txt', print_r($_POST, true)); // Log incoming data
include 'connection.php'; // Ensure database connection is included

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $operator_id = isset($_POST['operator_id']) ? (int) $_POST['operator_id'] : 0;
    $plate_id = $_POST['plate_id'] ?? '';
    $date = $_POST['date'] ?? '';
    $meter_type = $_POST['meter_type'] ?? '';

    // Validate inputs
    if (empty($operator_id) || empty($plate_id) || empty($date) || empty($meter_type)) {
        echo json_encode(['error' => 'Missing required parameters.']);
        exit;
    }

    // Query to fetch the last reading based on the meter type
    if ($meter_type === 'Odometer') {
        $query = "SELECT v.odoMeasureEnd, d.fullname, v.equipplate, v.equipdate
                  FROM equipsched v
                  JOIN driver d ON v.operator_id = d.id
                  WHERE v.operator_id = ? 
                    AND v.equipplate = ? 
                    AND DATE(v.equipdate) <= ? 
                    AND v.equipcategory = 'Odometer' 
                    AND v.odoMeasureEnd IS NOT NULL 
                    AND v.odoMeasureEnd != 0
                  ORDER BY v.equipdate DESC
                  LIMIT 1";
    } elseif ($meter_type === 'SMR') {
        $query = "SELECT v.smrMeasureEnd, d.fullname, v.equipplate, v.equipdate
                  FROM equipsched v
                  JOIN driver d ON v.operator_id = d.id
                  WHERE v.operator_id = ? 
                    AND v.equipplate = ? 
                    AND DATE(v.equipdate) <= ? 
                    AND v.equipcategory = 'SMR' 
                    AND v.smrMeasureEnd IS NOT NULL 
                    AND v.smrMeasureEnd != 0
                  ORDER BY v.equipdate DESC
                  LIMIT 1";
    } else {
        echo json_encode(['error' => 'Invalid meter type.']);
        exit;
    }

    $stmt = $conn->prepare($query);
    $stmt->bind_param('iis', $operator_id, $plate_id, $date);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        echo json_encode($data);
    } else {
        echo json_encode(['error' => 'No data found.']);
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'Invalid request method.']);
}
?>  