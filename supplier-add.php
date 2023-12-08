<?php

session_start();
if(!isset($_SESSION['user'])) header('Location: login.php');

$_SESSION['table'] = 'suppliers';
$_SESSION['redirect_to'] = 'supplier-add.php';

$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Supplier - Inventory Management System</title> <?php include('partials/app-header-scripts.php');?>
</head>
<body>
    <div id="dashboardMainContainer"> <?php include('partials/app-sidebar.php')?>
        <div class="dashboard_content_container" id="dashboard_content_container">
                <?php include('partials/app-topnav.php')?>
            <div class="dashboard_Main">
                <div class="row">
                    <div class="column column-12"> <h1 class="section_header">
                        <i class="fa fa-plus"></i>Create Supplier</h1>
                        <div class="dashboard_CM" id="userAddFormContainer">
                            <form action="database/add.php" method="POST" class="appform productContainer" id="myForm"
                                enctype="multipart/form-data">
                                <h2>Add Supplier</h2>
                                <div class="labels-input">
                                    <label for="supplier_name">Supplier Name</label>
                                    <br> <input type="text" placeholder="Enter Supplier Name" id="supplier_name"
                                    name="supplier_name" class="inputAF"> 
                                </div>
                                <div class="labels-input">
                                    <label for="supplier_location">Location</label> <br>
                                    <input type="text" placeholder="Add Supplier Location" class="inputAF" 
                                    id="supplier_location" name="supplier_location">
                                </div> 
                                <div class="suppliers labels-input">
                                    <label for="email">Email</label> 
                                    <input type="email" placeholder="Add Supplier Email" class="inputAF" 
                                    id="email" name="email">
                                </div> 
                                    <br> <button type="submit"><i class="fa fa-plus"></i> Create Supplier</button>
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