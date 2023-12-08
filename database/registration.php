<?php

    function connections(){
        
        $host = "localhost";
        $username = "root";
        $password = "12345";
        $database = "inventory";

        $con = new mysqli($host, $username, $password, $database);

        if($con->connect_error){
            echo $con->connect_error;
        }else{
            return $con;
        }
        
    }




//maganda ihiwalay ang connection para iko call nlng ang connection(); at less husle pag nagiba ka ng password kasi dito nlng iibahin mo di mo na gagalawin ang isa isa ang mga files
