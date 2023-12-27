<?php
    $type = $_GET['report'];
    $file_name = '.xls';
    
    $mapping_filenames = [
        'supplier' => 'Supplier Report',
        'product' => 'Product Report'
    ];

    //it will make the data convert into a csv file
    $file_name = $mapping_filenames[$type] . '.xls';
    header("Content-Disposition: attachment; filename=\"$file_name\"");
    header("Content-type: application/vnd.ms-excel");

    //Pull the data form database and insert it to the excel file
    include('connection.php');
    if($type === 'product'){
        $stmt = $conn->prepare("SELECT * FROM products INNER JOIN users ON products.created_by = users.id ORDER BY products.created_at DESC");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $products = $stmt->fetchAll();
        
        $is_header = true;
        foreach($products as $product){
            $product['created_by'] = $product['first_name'] .' '. $product['last_name'];
            //it will remove the data to array
            unset($product['first_name'], $product['last_name'], $product['password'], $product['email']);

            if($is_header){
                $row = (array_keys($product));
                $is_header = false; //to only run once
                echo implode("\t", $row) . "\n";
            }

            //to detect the right alignment of data before making it a csv file
            array_walk($row, function(&$str){
                $str = preg_replace("/\t/", "\\t", $str);
                $str = preg_replace("/\r?\n/", "\\n", $str);
                if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
            });

            echo implode("\t", $product) . "\n";
        }
    }

?>