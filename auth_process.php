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

    // instanciando dao
    $userDao = new UserDAO($conn, $BASE_URL);


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
            
            if($password === $confirmpassword){
                // verificando se as senhas batem
                if(strlen($password) >= 8 && strlen($confirmpassword)){
                   // verificando se tem 8 caracteres
                    if($userDao->findByEmail($email) === false){
                         // Se for false, é possível criar o usuário com este email

                        $user = new User();

                        //  criação de token único
                        $userToken = $user->generateToken();

                        // criando uma senha
                        $finalPassword = $user->generatePassword($password);

                        // montando o objeto
                        $user->name = $name;
                        $user->lastname = $lastname;
                        $user->email = $email;
                        $user->password = $finalPassword;//password final
                        $user->token = $userToken;

                        $auth = true; //autentificação verdadeira para a criação do userDAO, lá na função create($user, authuser)

                        $userDao->create($user, $auth);
                        
                        
                    }else{
                        // usuário já existe
                        $message->setMessage("Usuário já cadastrado, tente outro e-mail.", "error", "back");
                    }

                }else{
                    $message->setMessage("Senha: mínimo 8 caracteres.", "error", "back");
                }
                
            }else{
                $message->setMessage("As senhas não são iguais.", "error", "back");
            }

        }else{
            // msg de erro : dados faltantes
            $message->setMessage("Preencha todos os campos", "error", "back");
        }
       
        
    }else if($type === "login"){
        // autentificar o usuário

        $email = filter_input(INPUT_POST, "email");
        $password = filter_input(INPUT_POST, "password");

        
        if($userDao->authenticateUser($email, $password)){
            
            

        }else{
            // redirecionar se não conseguir autentificar
            $message->setMessage("Usuário e/ou senha incorretos.", "error", "back");
            
        }
    }else{
        $message->setMessage("Acesso inválido.", "error", "index.php");
    }

    



?>