<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
}

$show_table = 'suppliers';
$suppliers = include('database/show.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Purchase Orders - Inventory Management System</title>
    <?php include('partials/app-header-scripts.php'); ?>
    <link rel="stylesheet" href="CSS/view-order.css">
</head>

<body>
    <div id="dashboardMainContainer">
        <?php include('partials/app-sidebar.php')?>
        <div class="dashboard_content_container" id="dashboard_content_container">
            <?php include('partials/app-topnav.php')?>
            <div class="dashboard_Main">
                <div class="dashboard_content_main">
                    <div class="row">
                        <div class="column column-12">
                            <h1 class="section_header"><i class="fa fa-list"></i>List of Purchase Orders</h1>
                            <div class="poListContainers">
                                <?php
                                $stmt = $conn->prepare("SELECT order_product.id, products.product_name, 
                                                    order_product.quantity_ordered,
                                                    order_product.quantity_received, users.first_name, 
                                                    users.last_name,suppliers.supplier_name, 
                                                    order_product.status, order_product.created_at, order_product.batch
                                                    FROM order_product, suppliers, products, users
                                                    WHERE order_product.supplier = suppliers.id
                                                    AND order_product.product = products.id
                                                    AND order_product.created_by = users.id 
                                                    ORDER BY order_product.created_at DESC");
                                $stmt->execute();
                                $purchase_orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                $data = [];
                                foreach ($purchase_orders as $purchase_order) {
                                    $data[$purchase_order['batch']][] = $purchase_order;
                                }
                                ?>

                                <?php
                                foreach ($data as $batch_id => $batch_pos) {
                                ?>
                                    <div class="poList poCSS" id="container-<?= $batch_id ?>">
                                        <p>Batch#: <?= $batch_id ?></p>
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th class="indexSpace">#</th>
                                                    <th>Product Name</th>
                                                    <th style="padding-right: 10px;">Quantity ordered</th>
                                                    <th>Quantity received</th>
                                                    <th>Supplier</th>
                                                    <th>Status</th>
                                                    <th>Ordered by</th>
                                                    <th>Created date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($batch_pos as $index => $batch_po) {
                                                ?>
                                                    <tr>
                                                        <td> <?= $index + 1 ?></td>
                                                        <td class="po_product"><?= $batch_po['product_name'] ?></td>
                                                        <td class="po_qty_ordered qtyCenter"><?= $batch_po['quantity_ordered'] ?></td>
                                                        <td class="po_qty_received"><?= $batch_po['quantity_received'] ?></td>
                                                        <td class="po_qty_supplier"><?= $batch_po['supplier_name'] ?></td>
                                                        <td class="po_qty_status"><span class="po-badge po-badge-<?= $batch_po['status'] ?>"><?= $batch_po['status'] ?></span></td>
                                                        <td><?= $batch_po['first_name'] . ' ' . $batch_po['last_name'] ?></td>
                                                        <td><?= $batch_po['created_at'] ?>
                                                            <input type="hidden" class="po_qty_row_id" value="<?= $batch_po['id'] ?>">
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        <div class="poOrderUpdateBtnContainer">
                                            <button class="poBtn updatePoBtn" data-id="<?= $batch_id ?>">Update</button>
                                        </div>
                                    </div>
                                <?php 
                            } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php include('partials/app-scripts.php'); ?>

<script>

    function script(){
        var vm = this;

    this.registerEvents = function(){
        document.addEventListener('click', function(e){
            targetElement = e.target; //target element
            classList = targetElement.classList;


            if(classList.contains('updatePoBtn')){
                e.preventDefault(); //prevents the default mechanism

                batchNumber = targetElement.dataset.id;
                batchNumberContainer = 'container-' + batchNumber;

                //get all purchase order products records
                productList = document.querySelectorAll('#' + batchNumberContainer + ' .po_product');
                quantity_orderedList = document.querySelectorAll('#' + batchNumberContainer + ' .po_qty_ordered');
                quantity_receivedList = document.querySelectorAll('#' + batchNumberContainer + ' .po_qty_received');
                supplierList = document.querySelectorAll('#' + batchNumberContainer + ' .po_qty_supplier');
                statusList = document.querySelectorAll('#' + batchNumberContainer + ' .po_qty_status');
                rowIds = document.querySelectorAll('#' + batchNumberContainer + ' .po_qty_row_id');

                poListsArr = [];
                for(i=0; i<productList.length; i++){
                    poListsArr.push({
                        name: productList[i].innerText,
                        quantity_ordered: quantity_orderedList[i].innerText,
                        quantity_received: quantity_receivedList[i].innerText,
                        supplier: supplierList[i].innerText,
                        status: statusList[i].innerText,
                        id: rowIds[i].value
                    });
                }

                //store in HTML
    var poListHtml = `
                <table style="margin-top: -98%;" id="formTable_${batchNumber}">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th style="padding-right: 10px;">Quantity ordered</th>
                            <th>Quantity received</th>
                            <th>Supplier</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>`;

    poListsArr.forEach((poList) => {
        poListHtml += `
                        <tr>
                            <td class="po_product">${poList.name}</td>
                            <td class="po_qty_ordered qtyCenter">${poList.quantity_ordered}</td>
                            <td class="po_qty_received"><input type="number" value="${poList.quantity_received}"></td>
                            <td class="po_qty_supplier">${poList.supplier}</td>
                            <td>
                                <select class="po_qty_status">
                                    <option value="pending" ${poList.status} == 'pending' ? 'selected' : ''>pending</option>
                                    <option value="arrived" ${poList.status} == 'arrived' ? 'selected' : ''>arrived</option>
                                </select>
                                <input type="hidden" class="po_qty_row_id" value="${poList.id}">
                            </td>
                        </tr>
                        `;
                });
        poListHtml +=`</tbody></table>`;
                
        pName = targetElement.dataset.name;
                            
                BootstrapDialog.confirm({
                                type: BootstrapDialog.TYPE_PRIMARY,
                                title: 'Update Purchase Order: Batch #: <strong>'+ batchNumber +'</strong>',
                                message: poListHtml,
                            callback: function(toAdd){
                    //if we add
                    if(toAdd){   
                    formTableContainer = 'formTable_' + batchNumber;

                //get all purchase order products records
                quantity_receivedList = document.querySelectorAll('#' + formTableContainer + ' .po_qty_received');
                statusList = document.querySelectorAll('#' + formTableContainer + ' .po_qty_status');
                rowIds = document.querySelectorAll('#' + formTableContainer + ' .po_qty_row_id');

                poListsArrForm = [];
                for(i=0; i<quantity_receivedList.length; i++){
                    poListsArrForm.push({
                        quantity_ordered: quantity_orderedList[i].innerText,
                        quantity_received: quantity_receivedList[i].innerText,
                        supplier: supplierList[i].innerText,
                        status: statusList[i].innerText,
                        id: rowIds[i].value
                    });
                }

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
                                } 
                            });
                            }
                        });
                    }
                    }   
                });
            }

        });

    },
    

        this.initialize = function(){
            this.registerEvents();
        }
    }

    var script = new script;
    script.initialize();
</script>
</body>

</html>
