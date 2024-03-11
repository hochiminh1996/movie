<?php
include_once("templates/header.php");
?>
<div id="main-container" class="container-fluid">
    <h2 class="section-title">Filmes novos</h2>
    <p class="section-description">Veja as criticas dos últimos filmes</p>
    
    <div class="movies-container">
        <div class="card movie-card">
            <!-- imagem -->
            <div class="card-img-top" style="background-image: url('<?=$BASE_URL?>image/movies/movie_cover.jpg')"></div>

            <div class="card-body">
                <p class="card-rating">
                    <i class="fas fa-star"></i>
                    <!-- icone de estrela -->

                    <span class="rating">9</span>
                    <!-- nota -->
                </p>
                
                <h5 class="card-title">
                    <a href="#">Titulo do Filme</a>
                </h5>
                <a href="" class="btn btn-primary rate-btn">Avaliar</a>
                <a href="" class="btn btn-primary card-btn">Conhecer</a>
                
            </div>
        </div>
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