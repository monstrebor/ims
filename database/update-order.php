<?php
$purchase_orders = $_POST['payload'];
include('connection.php');

try{

    foreach ($purchase_orders as $po) {
            $delivered = (int) $po['quantity_delivered'];

        //we don't save data if it is zero received
        if($delivered > 0 ){
            $cur_qty_received = (int) $po['quantity_received'];
            $status = $po['status'];
            $row_id = $po['id'];
            $ordered = (int) $po['quantity_ordered'];

            // update quantity received
            $updated_qty_received = $cur_qty_received + $delivered;
            $qty_remaining = $ordered - $updated_qty_received;

            $sql = "UPDATE order_product 
                    SET
                    quantity_received = ?, status = ?, quantity_remaining = ?
                    WHERE id = ?";
        
            $stmt = $conn->prepare($sql);
            $stmt->execute([$updated_qty_received, $status, $qty_remaining, $row_id]);

            //insert a script adding to the order_product_history
            $delivery_history = [
                'order_product_id' => $row_id,
                'qty_received' => $delivered, 
                'date_received' => date('Y-m-d H:i:s'),
                'date_updated' => date('Y-m-d H:i:s')
            ];

        $sql = "INSERT INTO order_product_history
                    (order_product_id, qty_received, date_received, date_updated) 
                VALUES  
                    (:order_product_id, :qty_received, :date_received, :date_updated)";

        $stmt = $conn->prepare($sql);
        $stmt->execute($delivery_history);

        }

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
