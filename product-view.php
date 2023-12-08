<?php

session_start();
if(!isset($_SESSION['user'])) header('Location: login.php');

//it will get all products
$show_table = 'products';
$products = include('database/show.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Products - Inventory Management System</title> <?php include('partials/app-header-scripts.php');?> 
</head>
<body>
    <div id="dashboardMainContainer">
        <?php include('partials/app-sidebar.php')?>
        <div class="dashboard_content_container" id="dashboard_content_container">
                <?php include('partials/app-topnav.php')?>
            <div class="dashboard_Main">
                <div class="dashboard_content_main">
                    <div class="row">
                    <div class="column column-12"> <h1 class="section_header"><i class="fa fa-list"></i>List of Products</h1>
                        <div class="users">
                                        <p class="userCount">[ Total of 
                                        <?= count($products)?> Products ]</p>
                            <table>
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Image</th>
                                        <th>Product Name</th>
                                        <th width="10%">Description</th>
                                        <th width="10%">Suppliers</th>
                                        <th>created By</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <?php foreach ($products as $index => $product) { ?>
                                    <tr>
                                        <td><?= $index + 1 ?></td>
                                        <td class="firstName">
                                            <img class="productImages" src="uploads/products/<?= $product['img']?>" alt="product image">    
                                        </td>
                                        <td class="lastName"><?= $product['product_name'] ?></td>
                                        <td class="email"><?= $product['description'] ?></td>
                                        <td class="email">
                                            <?php
                                            $supplier_list ='-';

                                            $pid = $product['id'];
                                            $stmt = $conn->prepare("SELECT supplier_name 
                                                                    FROM suppliers, productsuppliers 
                                                                    WHERE productsuppliers.product =$pid
                                                                    AND productsuppliers.supplier = suppliers.id");
                                            $stmt->execute();
                                            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                            if($row){
                                                $supplier_arr = array_column($row, 'supplier_name');
                                                $supplier_list = implode("<ol>", $supplier_arr);
                                            }

                                            echo $supplier_list;
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $uid = $product['created_by'];
                                            $stmt = $conn->prepare("SELECT * FROM users WHERE id=$uid");
                                            $stmt->execute();
                                            $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                            $created_by_name = $row['first_name'] .' '. $row['last_name'];
                                            echo $created_by_name;
                                            ?>
                                        </td>
                                        <td><?= date('M d,Y h:i:s A', strtotime($product['created_at'])) ?></td>
                                        <td><?= date('M d,Y h:i:s A', strtotime($product['updated_at'] ))?></td>
                                        <td>
                                            <a href="" class="updateProduct"data-pid="<?= $product['id']?>">
                                                <i class="fa fa-pencil icon"></i>Edit |</a>
                                            <a href="" class="deleteProduct" data-name="<?= $product['product_name']?>"  data-pid="<?= $product['id']?>">
                                                <i class="fa fa-trash icon"></i>Delete</a>
                                        </td>
                                    </tr>
                                        <?php } ?>
                                </tbody>
                            </table>
                        </div></div></div></div></div></div></div>
    <?php
        include('partials/app-scripts.php');
        $show_table = 'suppliers';
        $suppliers = include('database/show.php');

        $suppliers_arr = [];

    
        foreach($suppliers as $supplier){
            $suppliers_arr[$supplier['id']] = $supplier['supplier_name'];
            }

            $suppliers_arr = json_encode($suppliers_arr);
    ?>
<script>
    var suppliersList = <?= $suppliers_arr?>;
        

    function script(){
        var vm = this;


    this.registerEvents = function(){
        document.addEventListener('click', function(e){
            targetElement = e.target; //target element
            classList = targetElement.classList;

            if(classList.contains('deleteProduct')){
                e.preventDefault(); //prevents the default mechanism

                pId = targetElement.dataset.pid;
                pName = targetElement.dataset.name;
                            
                BootstrapDialog.confirm({
                                type: BootstrapDialog.TYPE_DANGER,
                                title: 'Delete Product',
                                message:'Are you sure you want to delete <strong>'+ pName +'</strong>?',
                            callback: function(isDelete){
                                if(isDelete){
                            $.ajax({
                                method: 'POST',
                                data: {
                                id: pId,
                                table: 'products'
                                },
                                url: 'database/delete.php',
                                dataType: 'json',
                                success: function(data){
                                    message = data.success ?
                                        pName + ' successfully deleted' : 'Error processing your request!';

                                    BootstrapDialog.alert({
                                    type: data.success ? BootstrapDialog.TYPE_SUCCESS: BootstrapDialog.TYPE_DANGER,
                                    message: message,
                                    callback: function(){
                                        if(data.success) location.reload();
                                } });
                            }
                        });
                    }
                    }   
                })
            }

            if(classList.contains('updateProduct')){
                e.preventDefault(); //prevents the default mechanism

                pId = targetElement.dataset.pid;

                vm.showEditDialog(pId);
            }
        });

        document.addEventListener('submit', function(e){
            e.preventDefault();
            targetElement = e.target;

            if(targetElement.id === 'editProductForm'){
                vm.saveUpdatedData(targetElement);
            }
        })
    },

    this.saveUpdatedData = function(form){
        $.ajax({
                    method: 'POST',
                    data:new FormData(form),
                    url: 'database/update-product.php',
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(data){

                        BootstrapDialog.alert({
                            type: data.success ? BootstrapDialog.TYPE_SUCCESS : BootstrapDialog.TYPE_DANGER,
                            message: data.message,
                            callback: function(){
                                if(data.success) location.reload();
                            }
                        });
            }
        });
    }

    this.showEditDialog = function(id){
        $.get('database/get-product.php', {id: id}, function(productDetails){
            let curSuppliers = productDetails['suppliers'];
            let supplierOption = '';

            for (const [supId, supName] of Object.entries(suppliersList)) {
                selected = curSuppliers.indexOf(supId) > -1 ? 'selected' : '';
                supplierOption += "<option "+ selected +" value='" + supId + "'>"+ supName +"</option>";
            }
            BootstrapDialog.confirm({
                    title: 'Update <strong>'+ productDetails.product_name + '</strong>',
                    message: `<form action="database/add.php" method="POST" enctype="multipart/form-data" id="editProductForm">
                    <div class="labels-input">
                        <label for="product_name">Product Name</label>
                        <input type="text" placeholder="Enter Product Name" id="product_name" value="${productDetails.product_name}" name="product_name" class="inputAF">
                    </div>
                    <div class="suppliers labels-input">
                        <label for="description">Suppliers</label> 
                            <select id="suppliers" multiple="" name="suppliers[]" > 
                                <option>*Select Supplier*</option>
                                '+ ${supplierOption} +'
                        </select>
                    </div> 
                    <div class="labels-input">
                        <label for="description">Description</label>
                        <textarea class="inputAF productTextArea" placeholder="Add Product Description...." id="description" name="description"> ${productDetails.description} </textarea>
                    </div>
                    <div class="labels-input">
                        <label for="description">Product Image</label>
                        <input type="file" name="img"/>
                    </div>
                    <input type="hidden" name="pid" value="${productDetails.id}">
                    <input type="submit" value="submit" id="editProductSubmitBtn" class="hidden"/>
                    </form>
                    `,


                callback: function(isUpdate){
                if(isUpdate){ //if user click the OK button
                    document.getElementById('editProductSubmitBtn').click();
                    }
                }
        });
    }, 'json');
    }
    

        this.initialize = function(){
            this.registerEvents();
        }
    }

    var script = new script;
    script.initialize();
</script>
</body>
</html>