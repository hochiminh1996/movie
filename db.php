<?php 
    
    $host = "localhost";
    $user = "root";
    $db = "moviestar";
    $pass = "";


    try{
        $conn = new PDO("mysql:host=$host; dbname=$db", $user, $pass);

    }catch(Exception $e){
        echo "Erro: ".$e->getMessage();
    }



?>