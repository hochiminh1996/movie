<?php
    include_once("templates/header.php");
    include_once("dao/MovieDao.php");

    // dao do movie
    $movieDao = new MovieDao($conn, $BASE_URL);

    $latestMovie = $movieDao->getLatestMovie();
    // retorna array com filmes mais recentes


    $actionMovie = [];
    // array de filmes de ação [um das categorias]

    $comedyMovie = [];
    // array de filmes de comédia [um das categorias]

?>
<div id="main-container" class="container-fluid">
    <h2 class="section-title">Filmes novos</h2>
    <p class="section-description">Veja as criticas dos últimos filmes</p>
    
    <div class="movies-container">
        <?php 
            foreach($latestMovie as $movie):
        ?>
            <?php 
                require("templates/movie_card.php");
            ?>
            <!-- chamando os cards de filme com seus dados -->
        <?php
            endforeach;
        ?>
        
    </div>

    <h2 class="section-title">Ação</h2>
    <p class="section-description">Os melhores filmes de ação</p>
    <div class="movies-container"></div>

    <h2 class="section-title">Comédia</h2>
    <p class="section-description">Os melhores filmes de comédia</p>
    <div class="movies-container"></div>
</div>

<?php
include_once("templates/footer.php");
?>