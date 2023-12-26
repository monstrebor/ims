<?php


include('connection.php');

// Query the suppliers
$stmt = $conn->prepare("SELECT id, supplier_name FROM suppliers");
$stmt->execute();
$rows = $stmt->fetchAll();


$categories = [];
$bar_chart_data = [];

//query supplier product count
    foreach($rows as $row){
    $id = $row['id'];
    $categories[] = $row['supplier_name'];


    $stmt = $conn->prepare("SELECT COUNT(*) as p_count FROM productsuppliers WHERE productsuppliers.supplier='" .$id. "'");
    $stmt->execute();
    $row = $stmt->fetch();

    $count = $row['p_count'];
    $bar_chart_data[] = (int)$count;

    }








?>