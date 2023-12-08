<?php

session_start();
if(!isset($_SESSION['user'])) header('Location: login.php');
$_SESSION['table'] = 'users';
$_SESSION['redirect_to'] = 'users-add.php';

$show_table = 'users';
$users = include('database/show.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Users - Inventory Management System</title> <?php include('partials/app-header-scripts.php');?>
</head>
<body>
    <div id="dashboardMainContainer"> <?php include('partials/app-sidebar.php')?>
        <div class="dashboard_content_container" id="dashboard_content_container">
                <?php include('partials/app-topnav.php')?>
            <div class="dashboard_Main">
                <div class="row">
                    <div class="column column-12"> <h1 class="section_header"><i class="fa fa-plus"></i>Create User</h1>
                        <div class="dashboard_CM" id="userAddFormContainer">
                            <form action="database/add.php" method="POST" class="appform" id="myForm"><h2>Add User</h2>
                                <div class="labels-input">
                                    <label for="first_name">First Name</label>
                                    <br> <input type="text" placeholder="Enter your First name" id="first_name"
                                    name="first_name" class="inputAF">
                                </div>
                                <div class="labels-input">
                                    <label for="last_name">Last Name</label>
                                    <br> <input type="text" placeholder="Enter your Last name" id="last_name"
                                    name="last_name" class="inputAF">
                                </div>
                                <div class="labels-input">
                                    <label for="email">Email</label>
                                    <br> <input type="email" placeholder="Enter your email" id="email" name="email"
                                    class="inputAF">
                                </div>
                                <div class="labels-input">
                                    <label for="password">Password</label>
                                    <br> <input type="password" placeholder="Enter your password" id="password"
                                    name="password" class="inputAF">
                                </div>
                                    <br> <button type="submit"><i class="fa fa-plus"></i> Add User</button>
                            </form>
                                    <?php
                                    if(isset($_SESSION['response'])){ 
                                        $response_message = $_SESSION['response']['message'];
                                        $is_success = $_SESSION['response']['success'];?>
                            <div class="responseMessage">
                                        <p 
                                        class="response_message<?= $is_success ? 'responseMessage__success' : 
                                        'responseMessage__error' ?>">
                                        <?= $response_message?>
                                        </p>
                            </div>  <?php unset($_SESSION['response']);} ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <?php include('partials/app-scripts.php');?>
</body>
</html>