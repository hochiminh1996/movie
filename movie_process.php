<?php 

    require_once("db.php");
    // incluindo banco
    
    require_once("globals.php"); 
    // incluindo BASEURL

    require_once("models/Movie.php");
    // nossa classe principal

    require_once("models/Message.php");
    // incluindo a classe de msg

    require_once("dao/MovieDao.php");
    // incluindo a abstração de acesso/persistência de dados : movie

    require_once("dao/UserDAO.php");
    // incluindo a abstração de acesso/persistência de dados : user

   // instanciando a classe msg
    $message = new Message($BASE_URL);
    $movieDao = new MovieDao($conn, $BASE_URL);
    $userDao = new UserDAO($conn, $BASE_URL);

    $userData = $userDao->verifyToken();
    // verificando se há uma sessão de token

    // analisando o campo hidden
    if(filter_input(INPUT_POST, 'type')  == "create"){
        // dados de entrada do movie
        $title = filter_input(INPUT_POST, "title");
        $length = filter_input(INPUT_POST, "length");
        $category = filter_input(INPUT_POST, "category");
        $trailer = filter_input(INPUT_POST, "trailer");
        $description = filter_input(INPUT_POST, "description");

        $movie = new Movie();
        
        // validações básicas
        if(!empty($title) && !empty($length) && !empty($category) && !empty($trailer) && !empty($description)){
            // setando os dados no objeto
            $movie->title = $title;
            $movie->length = $length;
            $movie->category = $category;
            $movie->trailer = $title;
            $movie->description = $description;

            // upload de img/chegando o tipo da img
            if(isset($_FILES['image']) && !empty($_FILES['image']['tmp_name'])){
                $image = $_FILES['image'];
                $imageTypes = ["image/jpeg", "image/jpg", "image/png"];
                $jpegArray = ["image/jpeg", "image/jpg"];
                
                if(in_array($image['type'], $imageTypes)){
                    // se for um arquivo com um dos 3 tipos
                    if(in_array($image['type'], $jpegArray)){
                        // se for jpg/jpeg
                        $imageFile = imagecreatefromjpeg($image['tmp_name']);
                        // cria uma cópia do arquivo que chegou no input nas dimensões de jpeg a partir do caminho temporário
                    }else{
                        // é uma png
                        $imageFile = imagecreatefrompng($image['tmp_name']);
                    }

                    $imageName = $movie->generateImageName();
                    // gerando um novo nome

                    imagejpeg($imageFile, "./image/movies/".$imageName, 100);

                    $movie->image = $imageName;//setando o nome da imagem no obj movie


                }else{
                    $message->setMessage("Insira uma imagem .png/.jpeg/.jpg", "error", "back");
                }


            }
            var_dump($_POST, $_FILES);

            // inserindo no banco
            $movieDao->create($movie);
        }else{
            $message->setMessage("Preencha todos os campos", "error", "back");
        }



    }else{
        $message->setMessage("Erro: tente novamente", "error", "back");
   }
   

?>