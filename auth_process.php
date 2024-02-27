<?php 
    require_once("models/User.php");
    // incluindo o modelo de user

    require_once("dao/UserDAO.php");
    // incluindo a abstração de acesso/persistência de dados

    require_once("globals.php"); 
    // incluindo BASEURL

    require_once("db.php");
    // incluindo banco

    require_once("models/Message.php");
    // incluindo a classe de msg


    // instanciando a classe msg
    $message = new Message($BASE_URL);


    // verificando qual seção o formulário está processando.
    // Vai resgatar aquele input do tipo hidden, que tenha um name = type. Nesse caso, iremos saber se está vindo um value register ou login.
    $type = filter_input(INPUT_POST, "type");

    // resgata o tipo de formulário
    if($type === "register"){
        // cadastrar-se
        $name = filter_input(INPUT_POST, "name");
        $lastname = filter_input(INPUT_POST, "lastname");
        $email = filter_input(INPUT_POST, "email");
        $password = filter_input(INPUT_POST, "password");
        $confirmpassword = filter_input(INPUT_POST, "confirmpassword");


        // verificação de dados mínimos
        if($name && $lastname && $email &&  $password){
            echo "caouaqu";

        }else{
            // msg de erro : dados faltantes
            $message->setMessage("Preencha todos os campos", "error", "back");
        }
       
        
    }else if($type === "login"){
        // login
        $email = filter_input(INPUT_POST, "email");
        $password = filter_input(INPUT_POST, "password");
    }

    



?>