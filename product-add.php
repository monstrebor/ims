<?php

session_start();
if(!isset($_SESSION['user'])) header('Location: login.php');

$_SESSION['table'] = 'products';
$_SESSION['redirect_to'] = 'product-add.php';

$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product - Inventory Management System</title> <?php include('partials/app-header-scripts.php');?>
</head>
<body>
    <div id="dashboardMainContainer"> <?php include('partials/app-sidebar.php')?>
        <div class="dashboard_content_container" id="dashboard_content_container">
                <?php include('partials/app-topnav.php')?>
            <div class="dashboard_Main">
                <div class="row">
                    <div class="column column-12"> <h1 class="section_header">
                        <i class="fa fa-plus"></i>Create Product</h1>
                        <div class="dashboard_CM" id="userAddFormContainer">
                            <form action="database/add.php" method="POST" class="appform productContainer" id="myForm"
                                enctype="multipart/form-data">
                                <h2>Add Product</h2>
                                <div class="labels-input">
                                    <label for="product_name">Product Name</label>
                                    <br> <input type="text" placeholder="Enter Product Name" id="product_name"
                                    name="product_name" class="inputAF"> 
                                </div>
                                <div class="labels-input">
                                    <label for="description">Description</label> <br>
                                    <textarea  placeholder="Add Product Description...." class="inputAF productTextArea" 
                                    id="description" name="description"></textarea>
                                </div> 
                                <div class="suppliers labels-input">
                                    <label for="description">Suppliers</label> 
                                    <select id="suppliers" multiple="" name="suppliers[]" > 
                                        <option style="opacity: 0.25;">*Select Supplier*</option>
                                        <?php
                                            $show_table = 'suppliers';
                                            $suppliers = include('database/show.php');

                                            foreach($suppliers as $supplier){
                                                echo "<option value='". $supplier['id'] . "'>". $supplier['supplier_name'] . "</option>";
                                            }
                                        ?>
                                    </select>
                                </div> 
                                <div class="labels-input">
                                    <label for="description">Product Image</label> <br>
                                    <input type="file" name="img"/>
                                </div> 
                                    <br> <button type="submit"><i class="fa fa-plus"></i> Create Product</button>
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