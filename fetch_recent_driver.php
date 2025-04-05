<?php
include 'connection.php';

if (isset($_GET['driver_id'])) {
    $driver_id = $_GET['driver_id'];

    $query = "
        SELECT 
            v.equipdate, 
            d.fullname AS equipoperator,
            v.equipplate, 
            v.equiptype, 
            v.equipbrand, 
            v.equiparea, 
            v.equipnature, 
            v.distance, 
            v.hours, 
            v.fuelLiters, 
            v.fuelCost,
            v.odoMeasureStart,
            v.smrMeasureStart,
            v.odoMeasureEnd,
            v.smrMeasureEnd,
            v.equipcategory,
            v.equipstatus
        FROM equipsched v
        INNER JOIN driver d ON v.operator_id = d.id
        WHERE v.operator_id = $driver_id
        ORDER BY v.equipdate DESC
        LIMIT 5
    ";

    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['equipdate']) . "</td>";
            echo "<td>" . htmlspecialchars($row['equipoperator']) . "</td>";
            echo "<td>" . htmlspecialchars($row['equipplate']) . "</td>";
            echo "<td>" . htmlspecialchars($row['equiptype']) . "</td>";
            echo "<td>" . htmlspecialchars($row['equipbrand']) . "</td>";
            echo "<td>" . htmlspecialchars($row['equipnature']) . "</td>";
            echo "<td>" . htmlspecialchars($row['equiparea']) . "</td>";
            echo "<td>" . htmlspecialchars($row['odoMeasureStart']) . "</td>";
            echo "<td>" . htmlspecialchars($row['odoMeasureEnd']) . "</td>";
            echo "<td>" . htmlspecialchars($row['smrMeasureStart']) . "</td>";
            echo "<td>" . htmlspecialchars($row['smrMeasureEnd']) . "</td>";
            echo "<td>" . htmlspecialchars($row['distance']) . "</td>";
            echo "<td>" . htmlspecialchars($row['hours']) . "</td>";
            echo "<td>" . htmlspecialchars($row['fuelLiters']) . "</td>";
            echo "<td>" . htmlspecialchars($row['fuelCost']) . "</td>";
            echo "<td>" . htmlspecialchars($row['equipcategory']) . "</td>";
            echo "<td>" . htmlspecialchars($row['equipstatus']) . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='20'>No data found for this driver.</td></tr>";
    }
}
?>
