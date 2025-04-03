<?php
session_start();
include 'connection.php'; // Ensure DB connection

if (!isset($_GET['schedDate'])) {
    die("No date provided.");
}

$schedDate = $_GET['schedDate'];

// Fetch data for the selected date
$query = "SELECT * FROM equipsched WHERE equipdate = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $schedDate);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("No records found for this date.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print MORT</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .print-container { text-align: center; margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 10px; text-align: center; }
        .btn-print { margin-top: 20px; padding: 10px 20px; background: #007bff; color: white; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <div class="print-container">
        <h2>Maintenance and Operation Report Transaction (MORT)</h2>
        <p>Date: <strong><?= date("F d, Y", strtotime($schedDate)); ?></strong></p>

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Operator</th>
                    <th>Equipment Type</th>
                    <th>Brand</th>
                    <th>Plate #</th>
                    <th>Area</th>
                    <th>Nature</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $count = 1;
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$count}</td>
                            <td>{$row['equipoperator']}</td>
                            <td>{$row['equiptype']}</td>
                            <td>{$row['equipbrand']}</td>
                            <td>{$row['equipplate']}</td>
                            <td>{$row['equiparea']}</td>
                            <td>{$row['equipnature']}</td>
                          </tr>";
                    $count++;
                }
                ?>
            </tbody>
        </table>

        <button class="btn-print" onclick="window.print()">Print</button>
    </div>
</body>
</html>
