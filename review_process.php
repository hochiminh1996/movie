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

    $message = new Message($BASE_URL);
    $movieDao = new MovieDao($conn, $BASE_URL);
    $userDao = new UserDAO($conn, $BASE_URL);

    $userData = $userDao->verifyToken(true);
    // verificando se há uma sessão de token

    if(filter_input(INPUT_POST, "type") === "create"){
        $movies_id = filter_input(INPUT_POST, "movies_id");
        $rating = filter_input(INPUT_POST, "rating");
        $review = filter_input(INPUT_POST, "review");

        
    }
?>