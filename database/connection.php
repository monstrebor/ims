<?php

    // function connection(){
        
        $servername = "localhost";
        $username = "root";
        $password = "12345";
        // $database = "inventory";

        //Connecting to Database
        try {
            $conn = new PDO("mysql:host=$servername;dbname=inventory", $username, $password);
            //set the PDO error mode to exception.
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch (\Exception $e) {
            $error_message = $e->getMessage();
        }

        // $con = new mysqli($host, $username, $password, $database);

        // if($con->connect_error){
        //     echo $con->connect_error;
        // }else{
        //     return $con;
        // }
        
    // }
?>