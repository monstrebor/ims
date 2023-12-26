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










//bakit di mo na lang ipasok sa iisang database , pucha hirap at ang sagwa tignan pag i

//naka folder naman pre. baka pwede i apply yang idea mo di ko pa kasi gamay saka procedurial ka. mo modify ka pa yan pre. 

//madumi talaga tignan hahaha, 

//maganda ihiwalay ang connection para iko call nlng ang connection(); at less husle pag nagiba ka ng password kasi dito nlng iibahin mo di mo na gagalawin ang isa isa ang mga files
