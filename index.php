<?php
    include_once("templates/header.php");
    include_once("dao/MovieDao.php");

    // dao do movie
    $movieDao = new MovieDao($conn, $BASE_URL);

    $latestMovie = $movieDao->getLatestMovie();
    // retorna array com filmes mais recentes


    $actionMovie = $movieDao->getMoviesByCategory("Ação");
    // array de filmes de ação [um das categorias]

    $comedyMovie = $movieDao->getMoviesByCategory("Comédia");
    // array de filmes de comédia [um das categorias]

    $ficcaoMovie = $movieDao->getMoviesByCategory("Ficção");

    // var_dump($ficcaoMovie);exit;

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
        <?php 
            // se não hover filmes a serem exibidos
            if(count($latestMovie) == 0):
        ?>
            <p class="empty-list">Ainda não há filmes cadastrados!</p>
        <?php 
            endif;
        ?>

    </div>

    <h2 class="section-title">Ação</h2>
    <p class="section-description">Os melhores filmes de ação</p>
    <div class="movies-container">
        <!-- filmes de ação -->
        <?php 
            foreach($actionMovie as $movie){
                require("templates/movie_card.php");
            }
        ?>
      
        <?php 
            // se não hover filmes de ação a serem exibidos
            if(count($actionMovie) == 0):
        ?>
            <p class="empty-list">Ainda não há filmes de ação cadastrados!</p>
        <?php 
            endif;
        ?>
    </div>

    <h2 class="section-title">Comédia</h2>
    <p class="section-description">Os melhores filmes de comédia</p>
    <div class="movies-container">
        <?php 
            foreach($comedyMovie as $movie){
                require("templates/movie_card.php");
            }
        ?>

        <?php 
            // se não hover filmes de ação a serem exibidos
            if(count($comedyMovie) == 0):
        ?>
            <p class="empty-list">Ainda não há filmes de comédia cadastrados!</p>
        <?php 
            endif;
        ?>
    </div>
    
    <h2 class="section-title">Ficção Científica</h2>
    <p class="section-description">Os melhores filmes de ficção científica</p>
    <div class="movies-container">
        <?php 
            foreach($ficcaoMovie as $movie){
                require("templates/movie_card.php");
            }
        ?>

        <?php 
            // se não hover filmes de ação a serem exibidos
            if(count($comedyMovie) == 0):
        ?>
            <p class="empty-list">Ainda não há filmes de comédia cadastrados!</p>
        <?php 
            endif;
        ?>
    </div>
</div>

<?php
include_once("templates/footer.php");
?>