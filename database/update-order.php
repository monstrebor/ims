<?php
$purchase_orders = $_POST['payload'];

include('connection.php');

try{

    foreach ($purchase_orders as $po) {
        $received = (int) $po['quantity_received'];
        $status = $po['status'];
        $row_id = $po['id'];
        $ordered = (int) $po['quantity_ordered'];
    
        $qty_remaining = $ordered - $received;
    
        $sql = "UPDATE order_product 
                SET
                quantity_received = ?,
                status = ?,
                quantity_remaining = ?
                WHERE id = ?";
    
        $stmt = $conn->prepare($sql);
        $stmt->execute([$received, $status, $qty_remaining, $row_id]);
    }

    $response = [
        'success' => true,
        'message' => "Purchase order successfully updated."
    ];

}catch (\Exception $e){
    $response = [
        'success' => false,
        'message' => "Error processing your request."
    ];
}

echo json_encode($response);



?>
