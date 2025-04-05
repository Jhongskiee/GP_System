<?php
include 'connection.php'; // Database connection

$startDate = isset($_GET['from_startDate']) ? $_GET['from_startDate'] : null;
$endDate = isset($_GET['from_endDate']) ? $_GET['from_endDate'] : null;

if ($startDate && $endDate) {
    $query = "SELECT * FROM equipsched WHERE equipdate BETWEEN ? AND ? ORDER BY equipoperator, equipdate ASC";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $startDate, $endDate);
} else {
    $query = "SELECT * FROM equipsched ORDER BY equipoperator, equipdate ASC";
    $stmt = $conn->prepare($query);
}

// Execute query
$stmt->execute();
$result = $stmt->get_result();

// Organize Data by Driver + Month & Year
$groupedData = [];
while ($row = $result->fetch_assoc()) {
    $driver = $row['equipoperator'];
    $monthYear = date("F Y", strtotime($row['equipdate'])); // Example: "March 2025"
    $category = strtolower($row['equipcategory']); // 'odometer' or 'smr'
    $groupedData[$driver][$monthYear][$category][] = $row;
    $groupedData[$driver][$monthYear][] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Comprehensive - All Vehicle</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2, .header h3, .header h4, .header p { margin: 5px 0; font-size: 14px; font-weight: normal; }
        .header-flex {
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}

.logo {
    position: absolute;
    left: 0;
    top: 50%;
    transform: translateY(-50%);
}

.logo img {
    height: 80px; /* adjust as needed */
}

.header-text {
    text-align: center;
    margin: 0 auto;
}

        .abovetable { font-size: 14px; display: flex; justify-content: space-between; margin-bottom: 10px; border: 1px solid #000; padding-left: 5px; padding-right: 5px;}
        .abovetable p{margin:0; padding:0; font-weight: bold;}
        .table { width: 100%; border-collapse: collapse; font-size: 12px; margin-bottom: 20px; }
        .table, .table th, .table td { border: 1px solid black; }
        .table th, .table td { padding: 8px; text-align: center; }
        .footer { font-size: 12px; margin-top: 30px; }
        .page-break {
    page-break-before: always;
}
        @media print { body { margin: 0; } .no-print { display: none; } }
    </style>
</head>
<body>
<?php if (!empty($groupedData)) : ?>
    <?php 
$firstPage = true; // Add this before the outer loop
?>
    <?php foreach ($groupedData as $driver => $months) : ?>
        <?php foreach ($months as $monthYear => $categories) : ?>
            <?php foreach (['odometer', 'smr'] as $category) : ?>
            <?php if (!isset($categories[$category])) continue; ?>
            <?php $records = $categories[$category]; ?>

            <div class="<?= $firstPage ? '' : 'page-break' ?>">
            <?php $firstPage = false; // Flip after first output ?>

            <div class="header">
    <div class="header-flex">
        <div class="logo">
            <img src="logo.png" alt="Logo">
        </div>
        <div class="header-text">
            <h2>Republic of the Philippines</h2>
            <h3>Province of Davao del Norte</h3>
            <h3>City of Panabo</h3>
            <h3>-o0o-</h3>
            <h4><strong>GSO / MOTOR POOL SECTION</strong></h4>
            <h2>COMPREHENSIVE LIGHT/HEAVY VEHICLE HISTORY AND COST ANALYSIS</h2>
        </div>
    </div>
</div>
                <p style="font-size: 14px; margin-bottom: 0;">FOR THE MONTH OF: <span><strong><?= $monthYear ?></strong></span></p>
                <div class="abovetable">
                    <p>Unit Make: <span><?= htmlspecialchars($records[0]['equiptype']); ?></span></p>
                    <p>Unit Plate: <span><?= htmlspecialchars($records[0]['equipplate']); ?></span></p>
                    <p>Driver / Operator: <span><?= htmlspecialchars($driver); ?></span></p>
                    <p>Salary Rate: <span><strong><?= $monthYear ?></strong></span></p>
                </div>

            <?php
            // Initialize totals
            $totalBeginning = $totalEnding = $totalDistance = $totalHours = $totalFuel = 0;
            ?>

            <?php if ($category === 'odometer') : ?>
            
                <?php
                    $prevEnding = null; // Store previous row's ending value

                    foreach ($records as $index => $row) :
                        $beginning = isset($row['odoMeasure']) && is_numeric($row['odoMeasure']) ? (float)$row['odoMeasure'] : 0;
                        $distance = isset($row['distance']) && is_numeric($row['distance']) ? (float)$row['distance'] : 0.0;
                        $firstBeginning = isset($records[0]['odoMeasure']) && is_numeric($records[0]['odoMeasure']) ? (int)$records[0]['odoMeasure'] : 0;

                        // Condition 1: If Beginning & Distance are available → Ending = Beginning + Distance
                        if ($beginning && $distance) {
                            $ending = $beginning + $distance;
                        } 
                        // Condition 2: If Beginning exists but no Distance
                        elseif ($beginning && !$distance) {
                            if ($index == 0) {
                                $ending = 0;
                            } else {
                                $ending = $firstBeginning + ($beginning - $firstBeginning);
                            }
                        } 
                        // Condition 3: If Beginning is missing → Both Beginning & Ending should be 0
                        elseif (!$beginning) {
                            $beginning = $ending = 0;
                        } 
                        // Condition 4: If only Distance exists → Ending should catch the Distance
                        elseif ($distance && !$beginning) {
                            $ending = $distance;
                        } else {
                            $ending = 0;
                        }

                        // Fetch Fuel Value
                        $fuel = isset($row['fuelLiters']) && is_numeric($row['fuelLiters']) ? (float)$row['fuelLiters'] : 0;

                        // Update Totals
                        $totalBeginning += $beginning;
                        $totalEnding += $ending;
                        $totalDistance += $distance;
                        $totalFuel += $fuel;
                    ?>    
            <table class="table">
                <thead>
                    <tr>
                        <th rowspan="3">Date</th>
                        <th rowspan="3">Nature of Work</th>
                        <th rowspan="3">Location</th>
                        <th rowspan="3">Distance Travel</th>
                        <th rowspan="1" colspan="2">Fuel</th>
                        <th rowspan="1" colspan="14">Lubricants</th>
                        <th rowspan="2" colspan="2">Coolant</th>
                        <th rowspan="2" colspan="2">ADBLUE</th>
                        <th rowspan="1" colspan="3">Spare Parts</th>
                        <th rowspan="1" colspan="2">Equip. Time</th>
                        <th rowspan="3">Wages</th>
                        <th rowspan="3">ODOMETER</th>
                    </tr>
                    <tr>
                        <th rowspan="1" colspan="2">Diesel</th>
                        <th rowspan="1" colspan="2">Engine Oil</th>
                        <th rowspan="1" colspan="2">Trans. Oil</th>
                        <th rowspan="1" colspan="2">Gear Oil</th>
                        <th rowspan="1" colspan="2">Hyd. Oil</th>
                        <th rowspan="1" colspan="2">Brake Fluid</th>
                        <th rowspan="1" colspan="2">ATF</th>
                        <th rowspan="1" colspan="2">Grease</th>
                        <th rowspan="2">Qty.</th>
                        <th rowspan="2">Description</th>
                        <th rowspan="2">Cost</th>
                        <th rowspan="2">UT</th>
                        <th rowspan="2">AT</th>
                    </tr>
                    <tr>
                        <th>Ltrs.</th>
                        <th>Cost</th>
                        <th>Ltrs.</th>
                        <th>Cost</th>
                        <th>Ltrs.</th>
                        <th>Cost</th>
                        <th>Ltrs.</th>
                        <th>Cost</th>
                        <th>Ltrs.</th>
                        <th>Cost</th>
                        <th>Ltrs.</th>
                        <th>Cost</th>
                        <th>Ltrs.</th>
                        <th>Cost</th>
                        <th>Kgs.</th>
                        <th>Cost</th>
                        <th>Ltrs.</th>
                        <th>Cost</th>
                        <th>Ltrs.</th>
                        <th>Cost</th>
                    </tr>        
                </thead>
                <tbody>
                        <tr>
                            <td><?= date("d", strtotime($row['equipdate'])) ?></td>
                            <td><?= htmlspecialchars($row['equipnature']) ?></td>
                            <td><?= htmlspecialchars($row['equiparea']) ?></td>
                            <td><?= $distance ? htmlspecialchars($distance) : '' ?></td>
                            <td><?= $fuel ? htmlspecialchars($fuel) : '' ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td><strong>TOTAL</strong></td>
                        <td><strong><?= $totalBeginning ?></strong></td>
                        <td><strong><?= $totalEnding ?></strong></td>
                        <td><strong><?= $totalDistance ?></strong></td>
                        <td><strong><?= $totalFuel ?></strong></td>
                        <td></td>
                        <td></td>
                        <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                    </tr>
                </tfoot>
            </table>

            <?php elseif ($category === 'smr') : ?>
                    <?php
                    $prevEnding = null; // Store previous row's ending value

                    foreach ($records as $index => $row) :
                        $beginning = is_numeric($row['smrMeasure']) ? (float)$row['smrMeasure'] : 0; 
                        $hours = is_numeric($row['hours']) ? (float)$row['hours'] : 0.0;
$firstBeginning = isset($records[0]['smrMeasure']) && is_numeric($records[0]['smrMeasure']) ? (int)$records[0]['smrMeasure'] : 0; 

// Condition 1: If Beginning & Hours are available → Ending = Beginning + Hours
if ($beginning && $hours) {
    $ending = $beginning + $hours;
} 
// Condition 2: If Beginning exists but no Hours
elseif ($beginning && !$hours) {
    if ($index == 0) {
        $ending = 0;
    } else {
        $ending = $firstBeginning + ($beginning - $firstBeginning);
    }
} 
// Condition 3: If Beginning is missing → Both Beginning & Ending should be 0
elseif (!$beginning) {
    $beginning = $ending = 0;
} 
// Condition 4: If only Hours exists → Ending should catch the Hours
elseif ($hours && !$beginning) {
    $ending = $hours;
} else {
    $ending = 0;
}

// Fetch Fuel Value
$fuel = is_numeric($row['fuelLiters']) ? (float)$row['fuelLiters'] : 0;

// Update Totals
$totalBeginning += $beginning;
$totalEnding += $ending;
$totalHours += $hours;
$totalFuel += $fuel;
?>

<p style="margin-top: 0; font-size: 14px;">Normal Travel (km/liter): 
                <strong><?= ($totalFuel > 0) ? round($totalFuel / $totalHours, 2) : '0' ?></strong>
            </p>
                <!-- SMR TABLE -->
                <table class="table">
                <thead>
                    <tr>
                        <th rowspan="2">Date</th>
                        <th colspan="2">SMR Reading</th> 
                        <th rowspan="2">Num. of Hours (hr)</th> 
                        <th rowspan="2">Fuel (L)</th>
                        <th rowspan="2">Designated Area</th>
                        <th rowspan="2">Nature of Work</th>
                    </tr>
                    <tr>
                        <th>Beginning</th>
                        <th>Ending</th>
                    </tr>    
                </thead>
                <tbody>
                        <tr>
                            <td><?= date("F d", strtotime($row['equipdate'])) ?></td>
                            <td><?= $beginning ? htmlspecialchars($beginning) : '' ?></td>
                            <td><?= $ending ? htmlspecialchars($ending) : '' ?></td>
                            <td><?= $hours ? htmlspecialchars($hours) : '' ?></td>
                            <td><?= $fuel ? htmlspecialchars($fuel) : '' ?></td>
                            <td><?= htmlspecialchars($row['equiparea']) ?></td>
                            <td><?= htmlspecialchars($row['equipnature']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td><strong>TOTAL</strong></td>
                        <td><strong><?= $totalBeginning ?></strong></td>
                        <td><strong><?= $totalEnding ?></strong></td>
                        <td><strong><?= $totalHours ?></strong></td>
                        <td><strong><?= $totalFuel ?></strong></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
            <?php endif; ?> 

            <div class="footer">
                <p>I hereby certify to the correctness of the above statement and that the motor vehicle was used strictly on official business only</p>
                <div style="display: flex; justify-content: space-between;">
                    <div>
                        <span style="text-decoration:underline;"><?= htmlspecialchars($driver); ?></span>
                        <br>
                        <span>Name of Driver / Main Operator</span>
                    </div>
                    <div>
                        <span>Approved By:</span>
                        <br>
                        <span style="text-decoration:underline; margin-left: 100px;">ENGR. RANDEL B. PANAYANGAN, ME, MMPA</span>
                        <br>
                        <span style="margin-left: 100px;">CGADH - GSO</span>
                    </div>
                </div>
                <p style="margin-top: 50px;">Note:</p>
                    <p>This should be accomplished in triplicate the original of which, supported by the originals of duly accomplished Driver's Record of Travel (Form-A) should be submitted, thru the Administrative Officer or his equivalent
                        to the Auditor concerned (see Commission on Audit Circular No. 75-6)
                    </p>  
            </div>

                <?php endforeach; ?>
            <?php endforeach; ?>
        <?php endforeach; ?>
<?php else : ?>
    <p style="text-align:center; color:red;">No records found.</p>
<?php endif; ?>

</body>
</html>
