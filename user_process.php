<?php 
    // alterações de usuário
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

    // instanciando dao
    $userDao = new UserDAO($conn, $BASE_URL);

    $type = filter_input(INPUT_POST, "type");
    // o hidden que vem dos forms

    // atualizaçaõ de dados
    if($type==="update"){
        // verifica o token e resgata os dados do usuário se localizar. Retorna um obj
        $userData = $userDao->verifyToken();

        // receber dados do post
        $name = filter_input(INPUT_POST, "name");
        $lastname = filter_input(INPUT_POST, "lastname");
        $email = filter_input(INPUT_POST, "email");
        $bio = filter_input(INPUT_POST, "bio");
        // $image = filter_input(INPUT_POST, "image");
    
        // Passamos os dados que serão modificados
        $userData->name = $name;
        $userData->lastname = $lastname;
        $userData->email = $email;
        $userData->bio = $bio;
        // observe que estamos atualizado os dados em um objeto já existente o userData.

        $userDao->update($userData);
        //o método update exige outros camps, como token. No entanto, como estamos reaproveitando o objeto já existente (userData) apenas passamos os dados que queremos alterar. 


    }else if($type === "changepassword"){
        // atualizando senha
        $password = filter_input(INPUT_POST, "password");
        $confirmpassword = filter_input(INPUT_POST, "confirmpassword");
        var_dump($_POST);
    }else{
        $message->setMessage("Informações inválidas", "error", "index.php");
    }

?>