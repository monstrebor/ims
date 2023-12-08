<?php

session_start();
if(!isset($_SESSION['user'])) header('Location: login.php');
$user = $_SESSION['user'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <script src="https://use.fontawesome.com/0c7a3095b5.js"></script>
</head>
<body>
    <div id="dashboardMainContainer">
    <?php include('partials/app-sidebar.php')?>
        <div class="dashboard_content_container" id="dashboard_content_container">
            <div class="dashboard_topNav">
                <a href="" id="toggleBtn"><i class="fa fa-navicon"></i></a>
                <a href="database/logout.php" id="logoutBtn"><i class="fa fa-power-off"></i>Logout</a>
            </div>
                <div class="dashboard_content">
                    <div class="dashboard_content_main">
                    </div>
                </div>
        </div>
    </div>
    <script src="js/script.js"></script>
</body>
</html>