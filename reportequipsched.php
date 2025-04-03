<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username']; // Get the logged-in username

include 'connection.php'; // Ensure you have a database connection file

$from_month = $_GET['from_month'] ?? '';
$from_year = $_GET['from_year'] ?? '';
$to_month = $_GET['to_month'] ?? '';
$to_year = $_GET['to_year'] ?? '';

$condition = "";
if (!empty($from_month) && !empty($from_year) && !empty($to_month) && !empty($to_year)) {
    $from_date = "$from_year-$from_month-01";
    $to_date = "$to_year-$to_month-31"; // Covers entire month
    $condition = "WHERE equipdate BETWEEN '$from_date' AND '$to_date'";
}

// Fetch distinct dates from the database
$query = "SELECT equipdate, MAX(print_status) AS print_status 
          FROM equipsched 
          GROUP BY equipdate 
          ORDER BY equipdate DESC";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Dashboard - SB Admin</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="dashboardstyle.css" rel="stylesheet" />

    <!-- jQuery (must be before Bootstrap JS) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />

    <!-- FontAwesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!--Date Range Picker-->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <style>
    .cardheader:hover {
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.3); /* Shadow effect */
        transform: translateY(-5px);
        transition: all 0.3s ease-in-out;
    }
</style>
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
                                    <a class="nav-link" href="vehilogbook.php"><i class="fas fa-calendar-plus" style="margin-right: 10px;"></i> Vehicle Logbook</a>
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
                        <h1 class="mt-4">Equipment Schedule</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Equipment Schedule</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table mr-1"></i>
                                List of Vehicle Schedule
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <!-- Filter Form -->
                                    <div>
                                        <form action="" method="GET">
                                            <!-- Hidden input field to store the date range value -->
    <input type="hidden" id="daterange-input" name="equipdate" value="<?= isset($_GET['equipdate']) ? $_GET['equipdate'] : '' ?>">

    <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
        <i class="fa fa-calendar"></i>&nbsp;
        <span></span> <i class="fa fa-caret-down"></i>
    </div>
                                            <button type="submit" class="btn btn-primary">Filter</button>
                                        </form>    
                                    </div>
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $count = 1;
                                            while ($row = $result->fetch_assoc()) {
                                            ?>
                                                <tr>
                                                    <td><?= $count++; ?></td>
                                                    <td><?= date("F d, Y", strtotime($row['equipdate'])); ?></td>
                                                    <td><?= isset($row['print_status']) ? $row['print_status'] : 'Not Printed'; ?></td>
                                                    <td>
                                                        <button class="btn btn-primary btn-sm view-details" data-date="<?= $row['equipdate']; ?>">
                                                            View
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; GSO - MOTOR POOL 2025</div>
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

        <!-- Modal -->
<div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailsModalLabel">Equipment Schedule Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <!-- Selected Date Display -->
                    <h5 class="text-center font-weight-bold" id="selectedDateText"></h5>
                    <hr>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name of Driver/Operator</th>
                            <th>Type</th>
                            <th>Brand</th>
                            <th>Plate No.</th>
                            <th>Designated Area</th>
                            <th>Nature Of Work</th>
                        </tr>
                    </thead>
                    <tbody id="detailsTableBody">
                        <!-- Data will be inserted dynamically -->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary" id="printBtn">Print</button>
</div>
        </div>
    </div>
</div>

<!-- Second Modal (Update Entry) -->
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Update Equipment Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="updateId"> <!-- Store ID -->

                <div class="form-group">
                    <label>Name of Driver/Operator:</label>
                    <input type="text" class="form-control" id="updateOperator">
                </div>
                <div class="form-group">
                    <label>Type:</label>
                    <input type="text" class="form-control" id="updateType">
                </div>
                <div class="form-group">
                    <label>Brand:</label>
                    <input type="text" class="form-control" id="updateBrand">
                </div>
                <div class="form-group">
                    <label>Plate No.:</label>
                    <input type="text" class="form-control" id="updatePlate">
                </div>
                <div class="form-group">
                    <label>Designated Area:</label>
                    <input type="text" class="form-control" id="updateArea">
                </div>
                <div class="form-group">
                    <label>Nature of Work:</label>
                    <input type="text" class="form-control" id="updateNature">
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="confirmUpdateBtn">Confirm Update</button>
            </div>
        </div>
    </div>
</div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            $(document).ready(function () {
    // Handle "View Details" Click
    $(".view-details").click(function () {
        var selectedDate = $(this).data("date");

        var formattedDate = new Date(selectedDate).toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'long',
            day: '2-digit'
        });

        $("#selectedDateText").text(formattedDate);

        $.ajax({
            url: "fetch_sched_details.php",
            method: "POST",
            data: { date: selectedDate },
            dataType: "json",
            success: function (response) {
                var tableRows = "";
                $.each(response, function (index, item) {
                    tableRows += `
                        <tr data-id="${item.id}">
                            <td>${index + 1}</td>
                            <td>${item.equipoperator}</td>
                            <td>${item.equiptype}</td>
                            <td>${item.equipbrand}</td>
                            <td>${item.equipplate}</td>
                            <td>${item.equiparea}</td>
                            <td>${item.equipnature}</td>
                            <td><button class="btn btn-success updateRowBtn">Update</button></td>
                        </tr>`;
                });

                $("#detailsTableBody").html(tableRows);
                $("#detailsModal").modal("show");
            }
        });
    });

    // 🟢 Independent Filter Button Click Handler
    $("#filterBtn").click(function () {
        var fromMonth = $("#from_month").val();
        var fromYear = $("#from_year").val();
        var toMonth = $("#to_month").val();
        var toYear = $("#to_year").val();

        if (!fromMonth || !fromYear || !toMonth || !toYear) {
            Swal.fire({
                icon: "warning",
                title: "Invalid Filter",
                text: "Please select both From and To dates."
            });
            return;
        }

        $.ajax({
            url: "reportequipsched.php",
            method: "GET",
            data: { from_month: fromMonth, from_year: fromYear, to_month: toMonth, to_year: toYear },
            success: function (response) {
                $("#dataTable").html($(response).find("#dataTable").html()); // Reload table only
            }
        });
    });

    // 🟢 Unfilter (Reload Table Only)
    $("#unfilterBtn").click(function () {
        $.ajax({
            url: "reportequipsched.php",
            method: "GET",
            success: function (response) {
                $("#dataTableContainer").html($(response).find("#dataTableContainer").html()); // Reload table only
            }
        });
    });

    // 🟢 Print MOTR (Filtered Data)
    $("#printBtn").click(function () {
        var fromMonth = $("#from_month").val();
        var fromYear = $("#from_year").val();
        var toMonth = $("#to_month").val();
        var toYear = $("#to_year").val();

        if (!fromMonth || !fromYear || !toMonth || !toYear) {
            Swal.fire({
                icon: "warning",
                title: "Invalid Print",
                text: "Please select both From and To dates."
            });
            return;
        }

        window.open("mortPrint.php?from_month=" + fromMonth + "&from_year=" + fromYear + 
                    "&to_month=" + toMonth + "&to_year=" + toYear, "_blank");
    });

    // 🟢 Print Equipment Schedule
    $("#printBtnEquip").click(function () {
        var schedDate = $("#selectedDateText").text().replace("Date: ", "").trim();

        if (!schedDate) {
            Swal.fire({
                icon: "error",
                title: "Print Error",
                text: "No date selected to print."
            });
            return;
        }

        window.open("equipmentSchedPrint.php?schedDate=" + encodeURIComponent(schedDate), "_blank");

        $.ajax({
            url: "update_print_status.php",
            method: "POST",
            data: { date: schedDate },
            success: function (response) {
                if (response.trim() === "success") {
                    Swal.fire({
                        icon: "success",
                        title: "Printed",
                        text: "Print status updated successfully!"
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Update Failed",
                        text: response
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", status, error);
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Failed to update print status."
                });
            }
        });
    });

    // 🟢 Open Update Modal
    $(document).on("click", ".updateRowBtn", function () {
        var row = $(this).closest("tr");
        var id = row.data("id");

        $("#updateId").val(id);
        $("#updateOperator").val(row.children().eq(1).text());
        $("#updateType").val(row.children().eq(2).text());
        $("#updateBrand").val(row.children().eq(3).text());
        $("#updatePlate").val(row.children().eq(4).text());
        $("#updateArea").val(row.children().eq(5).text());
        $("#updateNature").val(row.children().eq(6).text());

        $("#updateModal").modal("show");
        $("#detailsModal").modal("hide");
    });

    // 🟢 Confirm Update
    $("#confirmUpdateBtn").click(function () {
        var id = $("#updateId").val();
        var equipoperator = $("#updateOperator").val();
        var equiptype = $("#updateType").val();
        var equipbrand = $("#updateBrand").val();
        var equipplate = $("#updatePlate").val();
        var equiparea = $("#updateArea").val();
        var equipnature = $("#updateNature").val();

        $.ajax({
            url: "update_sched_details.php",
            method: "POST",
            data: {
                id: id,
                equipoperator: equipoperator,
                equiptype: equiptype,
                equipbrand: equipbrand,
                equipplate: equipplate,
                equiparea: equiparea,
                equipnature: equipnature
            },
            success: function (response) {
                if (response.trim() === "Success") {
                    Swal.fire({
                        icon: "success",
                        title: "Updated!",
                        text: "Row updated successfully!"
                    }).then(() => {
                        $("#updateModal").modal("hide");
                        $("#detailsModal").modal("hide");
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Update Failed",
                        text: "Try again."
                    });
                }
            }
        });
    });

});

        </script>

<script type="text/javascript">
$(function() {

    var start = moment().subtract(29, 'days');
    var end = moment();

    function cb(start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }

    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    cb(start, end);

});
</script>
    </body>
</html>