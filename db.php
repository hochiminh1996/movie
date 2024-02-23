<?php 
    
    $host = "localhost";
    $user = "root";
    $db = "moviestar";
    $pass = "";



    try{
        $conn = new PDO("mysql:host=$host; dbname=$db", $user, $pass);

        // habilitando erros do PDO
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Conexão realizada com sucesso";

    }catch(Exception $e){
        echo "Erro: ".$e->getMessage();
    }



?>