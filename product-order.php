<?php

session_start();
if(!isset($_SESSION['user'])) header('Location: login.php');

//it will get all products
$show_table = 'products';

$products = include('database/show.php');
$products = json_encode($products);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Product - Inventory Management System</title> <?php include('partials/app-header-scripts.php');?>
    <link rel="stylesheet" href="CSS/product-order.css">
</head>
<body>
    <div id="dashboardMainContainer"> <?php include('partials/app-sidebar.php')?>
        <div class="dashboard_content_container" id="dashboard_content_container">
                <?php include('partials/app-topnav.php')?>
            <div class="dashboard_Main">
                <div class="row">
                    <div class="column column-12"> <h1 class="section_header">
                        <i class="fa fa-plus"></i>Order Product</h1>
                        <form action="database/save-order.php" method="POST">
                            <div class="addProd">
                            <button type="button" class="orderBtn" id="orderProductBtn">Add Another Product</button>
                            </div>
                            <div id="orderProductLists">
                                <p id="noData" style="color: #bbbbc2; ">No products selected.</p>
                            </div>
                            <div class="submitOrder">
                            <button type="submit" class="orderBtn submitOrderProductBtn">Submit order</button>
                        </div>
                        </form>
                    </div>
                            <?php if(isset($_SESSION['response'])){ 
                            $response_message = $_SESSION['response']['message'];
                            $is_success = $_SESSION['response']['success'];?>
                            <div class="responseMessage">
                            <p 
                            class="response_message<?= $is_success ? 'responseMessage__success' : 
                            'responseMessage__error' ?>">
                            <?= $response_message?>
                            </p>
                            </div><?php unset($_SESSION['response']);} ?>
                </div>
            </div>
        </div>
    </div> <?php include('partials/app-scripts.php');?>
    <script>
        var products = JSON.parse('<?= $products ?>');
        var counter = 0;

    function script(){

        var vm = this;

        let productOptions = `
            <div style="width: 100%">
                <label for="product_name">Product Name</label>
                <select class="productNameSelect" name="products[]" id="product_name">
                    <option value="">Select Product</option>
                    INSERTPRODUCTHERE
                </select>
                    <button class="removeOrderBtn">Remove</button>
            </div>`;

        this.initialize = function(){
            this.registerEvents();
            this.renderProductOptions();
        }
    
        this.renderProductOptions = function(){
            let optionHtml = '';
            products.forEach((product) => {
                optionHtml += '<option value="'+ product.id +'">'+ product.product_name +'</option>'
            })

            productOptions = productOptions.replace('INSERTPRODUCTHERE', optionHtml);
        }

        this.registerEvents = function() {

document.addEventListener('click', function(e) {
    targetElement = e.target; // target element
    classList = targetElement.classList;

    // add new product order event
    if (targetElement.id === 'orderProductBtn') {
        document.getElementById('noData').style.display = 'none';
        let orderProductListContainer = document.getElementById('orderProductLists');

        orderProductListContainer.innerHTML +=
            `<div class="rows orderProductRow">
                ${productOptions}
                <div class="suppliersRows" id="supplierRows_${counter}" data-counter="${counter}">
                </div>
            </div>`;

        counter++;
    }

    //if remove button is clicked
    if (targetElement.classList.contains('removeOrderBtn')){
        let orderRow = targetElement
        .closest('div.orderProductRow');

        orderRow.remove();
    }

});

document.addEventListener('change', function(e) {
    targetElement = e.target; // target element

    // add suppliers row on product option change
    if (targetElement.id === 'product_name') {
        let pid = targetElement.value;
        let counterId = targetElement
            .closest('div.orderProductRow')
            .querySelector('.suppliersRows')
            .dataset.counter;

        $.get('database/get-product-supplier.php', { id: pid }, function(suppliers) {
            vm.renderSupplierRows(suppliers, counterId);
        }, 'json');
    }
});
},


    this.renderSupplierRows = function(suppliers, counterId){
        let supplierRows = '';

        suppliers.forEach((supplier) => {
        supplierRows += // += sign will continuously append or add the supplier names
        `<div class="rows">
            <div style="width: 50%; font-weight: bold;">
            <p class="supplierName">${supplier.supplier_name}</p>
            </div>
            <div style="width: 40%;">
            <label for="quantity">Quantity: </label>
            <input type="number" placeholder="Enter Quantity" 
            id="quantity" class="appFormInput" name="quantity[${counterId}][${supplier.id}]"
            </div> 
        </div>`
        });

        //append the container
        let supplierRowContainer = document.getElementById('supplierRows_' + counterId);
        supplierRowContainer.innerHTML = supplierRows;
    }
}
    (new script()).initialize();
    </script>
</body>
</html>