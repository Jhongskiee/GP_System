<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['scheduleData'])) {
    $scheduleData = json_decode($_POST['scheduleData'], true);

    if (!empty($scheduleData)) {
        $stmt = $conn->prepare("INSERT INTO equipsched (equipdate, equipoperator, equipplate, equiptype, equipbrand, equiparea, equipnature, distance, hours, fuelLiters, fuelCost, odoMeasure, smrMeasure, print_status) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Not Printed')");

        if (!$stmt) {
            echo json_encode(["status" => "error", "message" => "Database error: " . $conn->error]);
            exit;
        }

        foreach ($scheduleData as $item) {
            $date = $item['date'];
            $operator = strtoupper($item['operator']);
            $plate = strtoupper($item['plate']);
            $type = strtoupper($item['type']);
            $brand = strtoupper($item['brand']);
            $area = strtoupper($item['area']);
            $nature = strtoupper($item['nature']);
            $odoMeasure = floatval($item['odoMeasure']);
            $smrMeasure = floatval($item['smrMeasure']);
            $distance = floatval($item['distance']);
            $hours = floatval($item['hours']);
            $fuelLiters = floatval($item['fuelLiters']);
            $fuelCost = floatval($item['fuelCost']);

            $stmt->bind_param("ssssssssddddd", $date, $operator, $plate, $type, $brand, $area, $nature, $distance, $hours, $fuelLiters, $fuelCost, $odoMeasure, $smrMeasure);

            if (!$stmt->execute()) {
                echo json_encode(["status" => "error", "message" => "Failed to insert: " . $stmt->error]);
                exit;
            }
        }

        $stmt->close();
        echo json_encode(["status" => "success", "message" => "Equipment schedule saved successfully!"]);
    } else {
        echo json_encode(["status" => "warning", "message" => "No schedule data received."]);
    }
}
?>
