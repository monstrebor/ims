<?php

session_start();
if(!isset($_SESSION['user'])) header('Location: login.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/report.css">
    <script src="https://use.fontawesome.com/0c7a3095b5.js"></script>
</head>
<body>
    <div id="dashboardMainContainer">
    <?php include('partials/app-sidebar.php')?>
        <div class="dashboard_content_container" id="dashboard_content_container">
            <?php include('partials/app-topnav.php')?>
            <div id="reportContainer">
                <div class="reportTypeContainer">
                    <div class="reportType">
                        <p>Export Products</p>
                        <div class="alignRight">
                            <a href="database/report_csv.php?report=product" class="reportExportBtn">Excel</a>
                            <a href="" class="reportExportBtn">PDF</a>
                        </div>
                    </div>
                    <div class="reportType">
                        <p>Export Suppliers</p>
                        <div class="alignRight">
                            <a href="database/report_csv.php?report=supplier" class="reportExportBtn">Excel</a>
                            <a href="" class="reportExportBtn">PDF</a>
                        </div>
                    </div>
                </div>
                <div class="reportTypeContainer">
                    <div class="reportType">
                        <p>Export Deliveries</p>
                        <div class="alignRight">
                            <a href="database/report_csv.php?report=product" class="reportExportBtn">Excel</a>
                            <a href="" class="reportExportBtn">PDF</a>
                        </div>
                    </div>
                    <div class="reportType">
                        <p>Export Purchase Orders</p>
                        <div class="alignRight">
                            <a href="database/report_csv.php?report=product" class="reportExportBtn">Excel</a>
                            <a href="" class="reportExportBtn">PDF</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="js/script.js"></script>
</body>
</html>