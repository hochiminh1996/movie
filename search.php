<?php
    include_once("templates/header.php");
    include_once("dao/MovieDao.php");

    // dao do movie
    $movieDao = new MovieDao($conn, $BASE_URL);

    // resgatando a busca do usuário
    $q = filter_input(INPUT_GET, "q");

    $movies = $movieDao->findByTitle($q);
?>
<div id="main-container" class="container-fluid">
    <h2 class="section-title">Buscando por: <span id="search-result"><?=$q?></span></h2>
    <p class="section-description">Resultado de busca:</p>
    
    <div class="movies-container">
        <?php 
            foreach($movies as $movie):
        ?>
        <?php 
            require("templates/movie_card.php");
        ?>
            <!-- chamando os cards de filme com seus dados -->
        <?php
            endforeach;
        ?>
        <?php 
            // se não hover filmes a serem exibidos
            if(count($movies) == 0):
        ?>
            <p class="empty-list">Busca não localizada, <a href="<?=$BASE_URL?>">Voltar</a>!</p>
        <?php 
            endif;
        ?>

    </div>
</div>

<?php
include_once("templates/footer.php");
?>