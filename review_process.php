<!-- área de processamento dos review de usuário -->

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

    require_once("dao/ReviewDao.php");
    require_once("models/Review.php");

    $message = new Message($BASE_URL);
    $movieDao = new MovieDao($conn, $BASE_URL);
    $userDao = new UserDAO($conn, $BASE_URL);
    $reviewDao = new ReviewDao($conn, $BASE_URL);

    $userData = $userDao->verifyToken(true);
    // verificando se há uma sessão de token para executar essa funçao. Retorna um objeto

    if(filter_input(INPUT_POST, "type") === "create"){
        $movies_id = filter_input(INPUT_POST, "movies_id");//id do filme
        $rating = filter_input(INPUT_POST, "rating");
        $review = filter_input(INPUT_POST, "review");

        $reviewObject = new Review();
        $movieDate = $movieDao->findById($movies_id);

        // SE O FILME EXISTIR
        if($movieDate){
            // verificar dados minimos
            if(!empty($movies_id) && !empty($rating) && !empty($review)){
                // criando um objeto review com os dados 
                $reviewObject->rating = $rating;
                $reviewObject->review = $review;
                $reviewObject->movies_id = $movies_id;
                $reviewObject->users_id = $userData->id;

                // colocando no banco
                $reviewDao->create($reviewObject);
            }else{
                $message->setMessage("Preencha nota e comentário", "error", "back");                
            }
        }else{
            $message->setMessage("Informações inválidas", "error", "back");
            
        }
    }
?>