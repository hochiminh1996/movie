<?php 
    require_once("templates/header.php");

    if($userDao){
        // se tiver logado
        $userDao->destroyToken();
    }


?>