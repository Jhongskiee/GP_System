<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username']; // Get the logged-in username

include 'connection.php'; // Ensure you have a database connection file
    ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Dashboard - SB Admin</title>
        <link href="dashboardstyle.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
        <!-- Include SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body class="sb-nav-fixed">

    <?php
if (isset($_SESSION['message'])) {
    echo "<script>
        Swal.fire({
            icon: '" . $_SESSION['status'] . "', // 'success' or 'error'
            title: 'Notification',
            text: " . json_encode($_SESSION['message']) . ",
            confirmButtonText: 'OK'
        });
    </script>";

    // Unset session variables to prevent repeated alerts on refresh
    unset($_SESSION['message']);
    unset($_SESSION['status']);
}
?>

        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <img src="logo.png" alt="Logo" style="height: 48px; margin-left: 10px;"> <a class="navbar-brand" href="dashboard.php">GP - MOTORPOOL</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ml-auto ml-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="#">Settings</a>
                        <a class="dropdown-item" href="#">Activity Log</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="login.php">Logout</a>
                    </div>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Core</div>
                            <a class="nav-link" href="dashboard.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            <div class="sb-sidenav-menu-heading">Interface</div>
                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-file-upload"></i></div>
                                Registration
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="vehilogbook.php"><i class="fas fa-calendar-plus" style="margin-right: 10px;"></i> Equipment Schedule</a>
                                </nav>
                            </div>
                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseReport" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-folder-open"></i></div>
                                Report
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseReport" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="reportequipsched.php"><i class="fas fa-paste" style="margin-right: 10px;"></i> Equipment Schedule</a>
                                </nav>
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="reportmrot.php"><i class="fas fa-paste" style="margin-right: 10px;"></i> MROT</a>
                                </nav>
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="reportallvehi.php"><i class="fas fa-paste" style="margin-right: 10px;"></i> MROT - All Vehicle</a>
                                </nav>
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="reportbreakdown.php"><i class="fas fa-paste" style="margin-right: 10px;"></i> Vehicle Breakdown Structure</a>
                                </nav>
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="reportstatus.php"><i class="fas fa-paste" style="margin-right: 10px;"></i> Monitoring of Equipment's Status</a>
                                </nav>
                            </div>
                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                                Pages
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                                        Authentication
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="login.html">Login</a>
                                            <a class="nav-link" href="register.html">Register</a>
                                            <a class="nav-link" href="password.html">Forgot Password</a>
                                        </nav>
                                    </div>
                                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                                        Error
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="401.html">401 Page</a>
                                            <a class="nav-link" href="404.html">404 Page</a>
                                            <a class="nav-link" href="500.html">500 Page</a>
                                        </nav>
                                    </div>
                                </nav>
                            </div>
                            <div class="sb-sidenav-menu-heading">Addons</div>
                            <a class="nav-link" href="charts.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Charts
                            </a>
                            <a class="nav-link" href="tables.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Tables
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        <?php echo $username; ?>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Equiment Schedule</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Equiment Schedule</li>
                        </ol>
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-table mr-1"></i>
                                        Recent Added
                                    </div>
                                    <div class="card-body">
                                        <table id="recentTable" class="table table-bordered" style="width: 100%;">
                                            <thead style="text-align: center; vertical-align: top;">
                                                <tr>
                                                    <th rowspan="2">Date</th>
                                                    <th rowspan="2">Drive/Operator</th>
                                                    <th colspan="3">Vehicle</th>
                                                    <th rowspan="2">Nature of Work</th>
                                                    <th rowspan="2">Location</th>
                                                    <th colspan="2">Odometer</th>
                                                    <th colspan="2">SMR</th>
                                                    <th colspan="2">Measure</th>
                                                    <th colspan="2">Fuel</th>
                                                    <th rowspan="2">Meter Type</th>
                                                    <th rowspan="2">Status</th>
                                                </tr>
                                                <tr>
                                                    <th>Plate #</th>
                                                    <th>Type</th>
                                                    <th>Brand</th>
                                                    <th>Beginning</th>
                                                    <th>Ending</th>
                                                    <th>Beginning</th>
                                                    <th>Ending</th>
                                                    <th>Distance Travel</th>
                                                    <th># of hours Travel</th>
                                                    <th>Ltrs</th>
                                                    <th>Cost</th>
                                                </tr>    
                                            </thead>
                                            <tbody style="text-align: center; vertical-align: top;">
                                            <tr><td colspan='20'>Please select a driver .</td></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>    
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Equipment Details
                                    </div>
                                    <div class="card-body">
                                        <form id="equipmentForm">
                                            <i class="fas fa-truck-monster d-flex" style="margin-left: 360px; font-size: 52px;"></i>
                                            <label class="form-label">Date</label>
                                            <input type="date" class="form-control mb-3" name="scheddate" id="scheddate">
                                            <label class="form-label">Name of Driver/Operator</label>
                                            <select class="form-control mb-3" id="schedoperator">
                                                <option value="">Select Driver</option>
                                                <?php
                                                $result = $conn->query("SELECT id, fullname FROM driver ORDER BY fullname ASC");
                                                while ($row = $result->fetch_assoc()) {
                                                    echo "<option value='" . $row['id'] . "'>" . $row['fullname'] . "</option>";
                                                }
                                                ?>
                                            </select>
                                            <label class="form-label">Plate No.</label>
                                            <select class="form-control mb-3" id="schedplate">
                                                <option value="">Select Plate Number</option>
                                                <?php
                                                include 'connection.php';
                                                $result = $conn->query("SELECT id, vehiplate FROM vehicle ORDER BY vehiplate ASC");
                                                while ($row = $result->fetch_assoc()) {
                                                    echo "<option value='" . $row['id'] . "'>" . $row['vehiplate'] . "</option>";
                                                }
                                                ?>
                                            </select>
                                            <label class="form-label">Type</label>
                                            <input type="text" class="form-control mb-3" name="schedtype" id="schedtype" style="text-transform: uppercase;">
                                            <label class="form-label">Brand</label>
                                            <input type="text" class="form-control mb-3" name="schedbrand" id="schedbrand" style="text-transform: uppercase;">
                                            <label class="form-label">Designated Area</label>
                                            <input type="text" class="form-control mb-3" name="schedarea" id="schedarea" style="text-transform: uppercase;">
                                            <label class="form-label">Nature of Work</label>
                                            <input type="text" class="form-control mb-4" name="schednature" id="schednature" style="text-transform: uppercase;">
                                            <label class="form-label">Type of Meter</label>
    <div class="mb-4">
    <input type="radio" name="meterType" value="Odometer" id="Odometer"> <label for="Odometer">Odometer</label>
    <input type="radio" name="meterType" value="SMR" id="SMR"> <label for="SMR">SMR</label>
                                            </div>

    <div id="odometerFields" style="display: none;">
            <div class="mb-4">
                Does the meter working?
            <input type="radio" name="meterFunction" value="odoYes" id="odoYes"> <label for="odoYes">Yes</label>
            <input type="radio" name="meterFunction" value="odoNo" id="odoNo"> <label for="odoNo">No</label>
            </div>
            <div id="odoWorking" style="display: none;">
                <div>
                <label class="form-label">Last Reading as of: </label><br><span id="odolastEnding"></span>
                                            </div>
                <label class="form-label">Current Reading: </label>
                <input type="text" class="form-control mb-3" name="odoCurrent" id="odoCurrent">
                <label class="form-label">New Reading: </label>
                <input type="text" class="form-control mb-3" name="odoNew" id="odoNew">
            </div>    
        <label class="form-label">Distance Travel</label>
        <input type="text" class="form-control mb-3" name="distanceTravel" id="distanceTravel">
    </div>
    
    <div id="smrFields" style="display: none;">
            <div class="mb-4">
                    Does the meter working?
                <input type="radio" name="meterFunction" value="smrYes" id="smrYes"> <label for="smrYes">Yes</label>
                <input type="radio" name="meterFunction" value="smrNo" id="smrNo"> <label for="smrNo">No</label>
            </div>
            <div id="smrWorking" style="display: none;">
                <div>
                <label class="form-label">Last Reading as of: </label><br><span id="smrlastEnding"></span>
                                            </div>
                <label class="form-label">Current Reading: </label>
                <input type="text" class="form-control mb-3" name="smrCurrent" id="smrCurrent">
                <label class="form-label">New Reading: </label>
                <input type="text" class="form-control mb-3" name="smrNew" id="smrNew">
            </div>
        <label class="form-label">Number of Hours Operate</label>
        <input type="text" class="form-control mb-3" name="hoursOperate" id="hoursOperate">
    </div>
    
    <div id="fuelFields" style="display: none;">
        <label class="form-label">Fuel Diesel Liters</label>
        <input type="text" class="form-control mb-3" name="fuelLiters" id="fuelLiters">
        <label class="form-label">Fuel Diesel Cost</label>
        <input type="text" class="form-control mb-3" name="fuelCost" id="fuelCost">
    </div>
                                            <button type="button" id="addToPreview" class="btn btn-outline-primary" style="margin-left: 360px; padding: 10px 20px;"><i class="fas fa-clipboard"></i> Enter</button>
                                        </form>    
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-paste mr-1"></i>
                                        Preview
                                    </div>
                                    <div class="card-body" >
                                    <div class="itemtable mb-4" style="height: 638px; border: 1px solid; overflow-x:auto; overflow-y:auto;">    
                                    <table class="table table-bordered " id="previewTable">
                                        <thead style="text-align: center; vertical-align: top;">
                                        <tr>
                                                    <th rowspan="2">Date</th>
                                                    <th rowspan="2">Drive/Operator</th>
                                                    <th colspan="3">Vehicle</th>
                                                    <th rowspan="2">Nature of Work</th>
                                                    <th rowspan="2">Location</th>
                                                    <th colspan="2">Odometer</th>
                                                    <th colspan="2">SMR</th>
                                                    <th colspan="2">Measure</th>
                                                    <th colspan="2">Fuel</th>
                                                    <th rowspan="2">Status</th>
                                                    <th rowspan="2">Action</th>
                                                </tr>
                                                <tr>
                                                    <th>Plate #</th>
                                                    <th>Type</th>
                                                    <th>Brand</th>
                                                    <th>Beginning</th>
                                                    <th>Ending</th>
                                                    <th>Beginning</th>
                                                    <th>Ending</th>
                                                    <th>Distance Travel</th>
                                                    <th># of hours Travel</th>
                                                    <th>Ltrs</th>
                                                    <th>Cost</th>
                                                </tr>    
                                        </thead>
                                        <tbody style="">
                                        </tbody>
                                    </table>
                                            </div>
                                    <button id="saveItems" class="btn btn-outline-success" style="margin-left: 360px; padding: 10px 20px;"><i class="fas fa-save"></i> Save Items</button>        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2020</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            document.querySelectorAll('input[name="meterType"]').forEach(radio => {
                radio.addEventListener('change', function() {
                    document.getElementById('odometerFields').style.display = this.value === 'Odometer' ? 'block' : 'none';
                    document.getElementById('smrFields').style.display = this.value === 'SMR' ? 'block' : 'none';
                    document.getElementById('fuelFields').style.display = 'block';
                });
            });
            document.querySelectorAll('input[name="meterFunction"]').forEach(radio => {
                radio.addEventListener('change', function() {
                    document.getElementById('odoWorking').style.display = this.value === 'odoYes' ? 'block' : 'none';
                    document.getElementById('smrWorking').style.display = this.value === 'smrYes' ? 'block' : 'none';
                });
            });
            $(document).ready(function () {
            // Fetch Type & Brand based on Plate No.
                $("#schedplate").change(function () {
                    var vehicleId = $(this).val();
                    if (vehicleId !== "") {
                        $.ajax({
                            url: "get_vehicle_details.php",
                            method: "POST",
                            data: { id: vehicleId },
                            dataType: "json",
                            success: function (response) {
                                if (response.success) {
                                    $("#schedtype").val(response.vehitype);
                                    $("#schedbrand").val(response.vehibrand);
                                } else {
                                    $("#schedtype").val("");
                                    $("#schedbrand").val("");
                                }
                            }
                        });
                    } else {
                        $("#schedtype").val("");
                        $("#schedbrand").val("");
                    }
                });

                // Add to Preview Table
                $("#addToPreview").click(function () {
                    var date = $("#scheddate").val();
                    var operator = $("#schedoperator option:selected").text();
                    var plate = $("#schedplate option:selected").text();
                    var type = $("#schedtype").val();
                    var brand = $("#schedbrand").val();
                    var area = $("#schedarea").val();
                    var nature = $("#schednature").val();
                    var odoMeasure = $("#odoMeasure").val();
                    var smrMeasure = $("#smrMeasure").val();
                    var distance = $("#distanceTravel").val();
                    var hours = $("#hoursOperate").val();
                    var fuelLiters = $("#fuelLiters").val();
                    var fuelCost = $("#fuelCost").val();

                    // Only require the date field
                        if (date !== "") {
                            var newRow = `
                                <tr>
                                    <td>${date}</td>
                                    <td>${operator}</td>
                                    <td>${plate}</td>
                                    <td>${type}</td>
                                    <td>${brand}</td>
                                    <td>${area}</td>
                                    <td>${nature}</td>
                                    <td>${odoMeasure}</td>
                                    <td>${smrMeasure}</td>
                                    <td>${distance}</td>
                                    <td>${hours}</td>
                                    <td>${fuelLiters}</td>
                                    <td>${fuelCost}</td>
                                    <td><button class="btn btn-sm btn-warning editRow">Edit</button>
                                        <button class="btn btn-sm btn-danger deleteRow">Delete</button></td>
                                </tr>
                            `;

                            $("#previewTable tbody").append(newRow);

                            // Clear all fields EXCEPT the date
                            // Reset the form, then re-set the date field's value.
                            $("#equipmentForm")[0].reset();
                            $("#scheddate").val(date);
                            // Also clear the readonly fields manually
                            $("#schedtype, #schedbrand").val("");
                        } else {
                            Swal.fire({
            icon: "warning",
            title: "No Data!",
            text: "Please select a date before adding!",
            confirmButtonColor: "#d33",
            confirmButtonText: "OK"});
                        }
                    });

                // Delete row from preview table
                $(document).on("click", ".deleteRow", function () {
                    $(this).closest("tr").remove();
                });

                // Edit row function
                $(document).on("click", ".editRow", function () {
                    var row = $(this).closest("tr");

                    // Get values from the row
                    var date = row.find("td:eq(0)").text();
                    var operator = row.find("td:eq(1)").text();
                    var plate = row.find("td:eq(2)").text();
                    var type = row.find("td:eq(3)").text();
                    var brand = row.find("td:eq(4)").text();
                    var area = row.find("td:eq(5)").text();
                    var nature = row.find("td:eq(6)").text();

                    // Populate the form
                    $("#scheddate").val(date);
                    $("#schedoperator").val(operator);
                    
                    // Set the plate dropdown value properly
                    $("#schedplate").val($("#schedplate option").filter(function () {
                        return $(this).text() === plate;
                    }).val());

                    // Trigger change event to update Type & Brand dynamically
                    $("#schedplate").trigger("change");

                    // Manually set Type and Brand if they are not dynamically updated
                    setTimeout(() => {
                        $("#schedtype").val(type);
                        $("#schedbrand").val(brand);
                    }, 500); // Small delay to allow AJAX to update fields

                    $("#schedarea").val(area);
                    $("#schednature").val(nature);

                    // Remove the row being edited
                    row.remove();
                });


                // Save Items to Database
                $("#saveItems").click(function () {
    var dataToSend = [];

    $("#previewTable tbody tr").each(function () {
        var row = {
            date: $(this).find("td:eq(0)").text(),
            operator: $(this).find("td:eq(1)").text(),
            plate: $(this).find("td:eq(2)").text(),
            type: $(this).find("td:eq(3)").text(),
            brand: $(this).find("td:eq(4)").text(),
            area: $(this).find("td:eq(5)").text(),
            nature: $(this).find("td:eq(6)").text(),
            odoMeasure: $(this).find("td:eq(7)").text(),
            smrMeasure: $(this).find("td:eq(8)").text(),
            distance: $(this).find("td:eq(9)").text(),
            hours: $(this).find("td:eq(10)").text(),
            fuelLiters: $(this).find("td:eq(11)").text(),
            fuelCost: $(this).find("td:eq(12)").text()
        };
        dataToSend.push(row);
    });

    console.log("Data to send:", dataToSend);

    if (dataToSend.length > 0) {
        $.ajax({
            url: "save_equipment_schedule.php",
            method: "POST",
            data: { scheduleData: JSON.stringify(dataToSend) },
            dataType: "json",
            success: function (response) {
                console.log("Response from server:", response);
                Swal.fire({
                    icon: response.status,
                    title: response.status === "success" ? "Success!" : "Warning!",
                    text: response.message,
                    confirmButtonColor: response.status === "success" ? "#3085d6" : "#d33",
                    confirmButtonText: "OK"
                }).then(() => {
                    if (response.status === "success") {
                        $("#previewTable tbody").empty(); // Clear table on success
                    }
                });
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", xhr.responseText);
                Swal.fire({
                    icon: "error",
                    title: "Error!",
                    text: "Failed to save data. Please try again.",
                    confirmButtonColor: "#d33",
                    confirmButtonText: "OK"
                });
            }
        });
    } else {
        Swal.fire({
            icon: "warning",
            title: "No Data!",
            text: "No items to save!",
            confirmButtonColor: "#d33",
            confirmButtonText: "OK"
        });
    }
});

            });

            document.getElementById("schedoperator").addEventListener("change", function() {
    const operatorId = this.value;

    if (operatorId !== "") {
        fetch("fetch_recent_driver.php?driver_id=" + operatorId)
            .then(response => response.text())
            .then(data => {
                document.querySelector("#recentTable tbody").innerHTML = data;
            });
    } else {
        document.querySelector("#recentTable tbody").innerHTML = "<tr><td colspan='20'>Select a driver to view recent data.</td></tr>";
    }
});

function fetchLastReading() {
    
    const operator = document.getElementById("schedoperator").value;
    const plate = document.getElementById("schedplate").options[document.getElementById("schedplate").selectedIndex].text;
    const date = document.getElementById("scheddate").value;
    const meterType = document.querySelector('input[name="meterType"]:checked')?.value; // Get selected meter type

    console.log("Sending:", { operator, plate, date, meterType });

    if (operator && plate && date) {
        fetch('get_last_reading.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: new URLSearchParams({
                operator_id: operator,
                plate_id: plate,
                date: date,
                meter_type: meterType // Include the selected meter type
            })
        })
        .then(res => res.json().catch(() => { throw new Error("Invalid JSON received"); }))
        .then(data => {
            console.log("Response Data:", data); // Debugging output

            if (data.error) {
                // If no previous record, set odoCurrent to the value of odoNew
                document.getElementById("odolastEnding").innerText = "No previous data found.";
                const odoNewValue = document.getElementById("odoNew").value;
                document.getElementById("odoCurrent").value = odoNewValue;
                // If no previous record, set smrCurrent to the value of smrNew
                document.getElementById("smrlastEnding").innerText = "No previous data found.";
                const smrNewValue = document.getElementById("smRNew").value;
                document.getElementById("smrCurrent").value = smrNewValue;
            } else {
                document.getElementById("odolastEnding").innerText =
                    `${data.fullname} - ${data.equipplate} - ${data.equipdate} - ${data.odoMeasureEnd}`;
                //assigned the odoMeasureEnd in odoCurrent textfield
                document.getElementById("odoCurrent").value = data.odoMeasureEnd;
                // Calculate the distanceTravel when odoNew is updated
                document.getElementById("odoNew").addEventListener("input", function () {
                    const odoCurrentValue = parseFloat(document.getElementById("odoCurrent").value);
                    const odoNewValue = parseFloat(this.value);

                    if (!isNaN(odoCurrentValue) && !isNaN(odoNewValue) && odoNewValue >= odoCurrentValue) {
                        document.getElementById("distanceTravel").value = (odoNewValue - odoCurrentValue).toFixed(2);
                    } else {
                        document.getElementById("distanceTravel").value = ""; // Clear if invalid
                    }
                });

                // If SMR is selected, fetch the last reading for SMR
                document.getElementById("smrlastEnding").innerText =
                    `${data.fullname} - ${data.equipplate} - ${data.equipdate} - ${data.smrMeasureEnd}`;
                //assigned the odoMeasureEnd in odoCurrent textfield
                document.getElementById("smrCurrent").value = data.smrMeasureEnd;
                // Calculate the hoursOperate when smrNew is updated
                document.getElementById("smrNew").addEventListener("input", function () {
                    const smrCurrentValue = parseFloat(document.getElementById("smrCurrent").value);
                    const smrNewValue = parseFloat(this.value);

                    if (!isNaN(smrCurrentValue) && !isNaN(smrNewValue) && smrNewValue >= smrCurrentValue) {
                        document.getElementById("hoursOperate").value = (smrNewValue - smrCurrentValue).toFixed(2);
                    } else {
                        document.getElementById("hoursOperate").value = ""; // Clear if invalid
                    }
                });
            }
        })
        .catch(error => {
            console.error("Fetch error:", error);
            document.getElementById("odolastEnding").innerText = "Error fetching data.";
        });
    }
}

// Trigger on change
document.getElementById("schedoperator").addEventListener("change", fetchLastReading);
document.getElementById("schedplate").addEventListener("change", fetchLastReading);
document.getElementById("scheddate").addEventListener("change", fetchLastReading);
document.querySelectorAll('input[name="meterType"]').forEach(radio => {
    radio.addEventListener("change", fetchLastReading);
});

// Update odoCurrent when odoNew changes (if no previous data exists)
document.getElementById("odoNew").addEventListener("input", function () {
    const odoLastEndingText = document.getElementById("odolastEnding").innerText;
    if (odoLastEndingText.includes("No previous data found.")) {
        document.getElementById("odoCurrent").value = this.value;
    }
});

// Update smrCurrent when odoNew changes (if no previous data exists)
document.getElementById("smrNew").addEventListener("input", function () {
    const odoLastEndingText = document.getElementById("smrlastEnding").innerText;
    if (odoLastEndingText.includes("No previous data found.")) {
        document.getElementById("smrCurrent").value = this.value;
    }
});
        </script>
    </body>
</html>
