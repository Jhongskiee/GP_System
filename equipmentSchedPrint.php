<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipment Schedule Print</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2, .header h3, .header h4 {
            margin: 5px 0;
            font-size: 14px;
            font-weight: normal;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }
        .table, .table th, .table td {
            border: 1px solid black;
        }
        .table th, .table td {
            padding-left: 8px;
            padding-right: 8px;
            text-align: center;
        }
        .footer {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            margin-top: 20px;
        }
        .footer .name {
            margin-top: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .footer .position {
            font-size: 14px;
        }
        @media print {
            body {
                margin: 0;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Republic of the Philippines</h2>
        <h3>Province of Davao del Norte</h3>
        <h3>City of Panabo</h3>
        <h4><strong>City General Services Office - Motor Pool Section</strong></h4>
        <h2><strong>E Q U I P M E N T  S C H E D U L E</strong></h2>
        <h3 style="text-decoration:underline"><span id="scheduleDate"></span></h3>
    </div>

    <table class="table">
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
        <tbody id="tableBody">
            <!-- Data inserted dynamically -->
        </tbody>
    </table>

    <div class="footer">
        <div>
            <div>Prepared By:</div>
            <div class="name" style="text-decoration:underline">ROMIL B. AMIGO</div>
            <div class="position">Administrative Aide I</div>
        </div>
        <div>
            <div>Checked By:</div>
            <div class="name" style="text-decoration:underline">ENGR. GINO PAULO G. ABREGANA, ME</div>
            <div class="position">Engineer I-Motor Pool Section</div>
        </div>
        <div>
            <div>Noted By:</div>
            <div class="name" style="text-decoration:underline">ENGR. ALEXIS A. CUAMAG, ME</div>
            <div class="position">Engineer III-Motor Pool Section</div>
        </div>
        <div>
            <div>Approved By:</div>
            <div class="name" style="text-decoration:underline">ENGR. RANDEL B. PANAYANGAN, ME, MMPA</div>
            <div class="position">CGADH-GSO</div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // Get the schedule date from URL parameter
        const urlParams = new URLSearchParams(window.location.search);
        const schedDate = urlParams.get('schedDate');
        document.getElementById('scheduleDate').innerText = schedDate;

        // Fetch data from database using AJAX
        fetch(`fetch_equipment_data.php?schedDate=${encodeURIComponent(schedDate)}`)
            .then(response => response.json())
            .then(data => {
                console.log("Fetched Data:", data); // Debugging: Check the console
        const tableBody = document.getElementById("tableBody");
        if (data.length === 0) {
            tableBody.innerHTML = `<tr><td colspan="7">No records found for this date.</td></tr>`;
        } else {
                let rows = "";
                data.forEach((item, index) => {
                    rows += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${item.equipoperator}</td>
                            <td>${item.equiptype}</td>
                            <td>${item.equipbrand}</td>
                            <td>${item.equipplate}</td>
                            <td>${item.equiparea}</td>
                            <td>${item.equipnature}</td>
                        </tr>
                    `;
                });
                tableBody.innerHTML = rows;
            }
                // ✅ Print after data is fully loaded
        setTimeout(() => {
            window.print();
        }, 1000); // Delay ensures data is loaded before printing
            })
            .catch(error => console.error("Error fetching data:", error));
    </script>
</body>
</html>
