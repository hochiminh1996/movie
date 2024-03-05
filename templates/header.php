<?php
    include_once("globals.php");
    include_once("db.php");
    include_once("models/Message.php");
    include_once("dao/UserDAO.php");

    $message  = new Message($BASE_URL);
    //instancia de msg

    $flassMessage = $message->getMessage();//recuperando a msg. Retorna um array com o tipo de erro/sucesso e a mensagem

    // se já tiver uma msg na session, ele irá limpar. Caso contrário, ele seguirá o fluxo de execução. Lá auth_process, se usuário provocar um erro, irá mostrar irá criar uma session com o erro
    if(!empty($flassMessage['msg'])){
        // limpar msg
        $message->clearMessage();
    }

    $userDao = new UserDAO($conn, $BASE_URL);
    $userData = $userDao->verifyToken(false);



?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <title>MovieStar</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?= $BASE_URL ?>image/moviestar.ico" type="image/x-icon">


    <!-- css do boostrap twitter : bootstrap.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.css" integrity="sha512-drnvWxqfgcU6sLzAJttJv7LKdjWn0nxWCSbEAtxJ/YYaZMyoNLovG7lPqZRdhgL1gAUfa+V7tbin8y+2llC1cw==" crossorigin="anonymous" />

    <!-- Font Awesome icones-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
    <!-- CSS do projeto -->
    <link rel="stylesheet" type="text/css" href="<?= $BASE_URL ?>css/style.css">

</head>

<body>
    <header>
        <nav id="main-navbar" class="navbar navbar-expand-lg">
            <a href="<?= $BASE_URL ?>" class="navbar-brand">
                <img src="<?= $BASE_URL ?>image/logo.svg" alt="x" id="logo">
                <span id="moviestar-title">MovieStar</span>
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>

            <form action="" method="get" id="search-form" class="form-inline my-2 my-leg-0">
                <input type="text" name="q" id="search" class="form-control mr-sm-2" type="search" placeholder="Buscar filme" aria-label="Search">
                <button class="btn my-2 my-sm-0" type="submit">
                    <i class="fas fa-search"></i>
                </button>

            </form>

            <!-- essa div será afetada pelo jquery -->
            <div class="collapse navbar-collapse" id="navbar">
                <ul class="navbar-nav">
                    <?php 
                        // se tiver dados
                        if($userData):
                    ?>

                    <li class="nav-item">
                        <a class="nav-link" href="<?= $BASE_URL ?>newmovie.php" class="nav-link"><i class="far fa-plus-square"></i> Incluir Filme</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?= $BASE_URL ?>dashboard.php" class="nav-link">Meus Filmes</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?= $BASE_URL ?>editprofile.php" class="nav-link bold">
                            <?= 
                                $userData->name;
                            ?>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?= $BASE_URL ?>logout.php" class="nav-link bold">Sair
                        </a>
                    </li>
                    <?php else:?>

                    <!-- SE NÃO TIVER SESSÃO, ELE MOSTRA ESSA NAVBAR DE ENTRAR/CADASTRAR -->
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $BASE_URL ?>auth.php" class="nav-link">Entrar/Cadastrar</a>
                    </li>
                    <?php endif;?>

                </ul>
            </div>
        </nav>
    </header>

    <?php
    if (!empty($flassMessage['msg'])) :
    ?>
    <div class="msg-container">
        <p class="msg <?=$flassMessage['type']?>"><?=$flassMessage['msg']?></p>
    </div>

    <?php endif; ?>
   