<!-- visualizar o filme -->
<?php 
    include_once("templates/header.php");
    // verificação se usuário está autentificado
    include_once("dao/MovieDao.php");
    include_once("models/Movie.php");
    include_once("dao/ReviewDao.php");



    // pegar o id do filme
    $id = filter_input(INPUT_GET, "id");

    $movie;
    $reviewDao = new ReviewDao($conn, $BASE_URL);

    if(!empty($id)){
        $movieDao = new MovieDao($conn, $BASE_URL);
        // verificando se o filme existe por id
        $movie = $movieDao->findById($id);
        
        if($movie == null){
            $message->setMessage("Null: Filme não localizado", "error", "index.php");
        }

    }else{
        $message->setMessage("Filme não localizado", "error", "index.php");
    }

    // VERIFICANDO SE O FILME TEM IMAGEM
    if($movie->image == "" || $movie->image == NULL){
        $movie->image = "movie_cover.jpg";
    }

    // VERIFICANDO SE O FILME É DO USUÁRIO. (o usuário não poderá comentar o filme que adicionou)
    $userOwnsMovie = false;

    // userData está vindo do header
    if(!empty($userData)){

        // se $userData for false, significa que não está logado

        if($userData->id === $movie->users_id){
            // verificando se o id do usuário é igual ao id do usuário que adicionou o filme. Ou seja, foi ele que adicionou.
            $userOwnsMovie = TRUE;
        }
    }

    // ARRAY QUE CONTÉM RESGATA TODAS AS REVIEWS
    $moviesReview = $reviewDao->getMoviesReview($id);

    // RESGATANDO AS REVIEWS DO FILME
    $alreadyReview = false;
?>

<div id="main-container" class="container-fluid">
    <div class="row">
        <div class="offset-md-1 col-md-6 movie-container">
            <h1 class="page-title"><?=$movie->title?></h1>
            <p class="movie-details">
                <span class="">Duração: <?=$movie->length?></span>
                <span class="pipe"></span>

                <span><?=$movie->category?></span>
                <span class="pipe"></span>

                <span><i class="fas fa-star"></i> 9</span>
            </p>

         
            <iframe class="iframe-video" width="560" height="315" src="<?= $movie->trailer ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

            <p><?=$movie->description?></p>
        
        </div>

        <div class="col-md-4">
            <div class="movie-image-container" style="background-image: url('<?=$BASE_URL?>image/movies/<?=$movie->image?>');"></div>        
        </div>

        <div class="offset-md-1 col-md-10" id="reviews-container">
            <h3 id="reviews-title">Avaliações</h3>
            
            <!-- VERIFICA SE HABILITA A REVIEW PARA USUÁRIO OU NÃO  -->
            <?php 
                // A review será habilitada se o usuário estiver logado (userData), se ele não for o usuário que inseriu o filme e se ele ainda n fez uma review.
                if(!empty($userData) && !$userOwnsMovie && !$alreadyReview):
            ?>

            <div class="col-md-12" id="review-form-container">
                <h4>Envie sua avaliação</h4>
                <p class="page-description">Preencha o formulário com a nota e comentário sobre o filme: </p>
                <!-- REVIEW QUE SERÁ REALIZADO PELO USUÁRIO -->
                <form action="<?=$BASE_URL?>review_process.php" method="POST" enctype="multipart/form-data" id="review-form">
                    <input type="hidden" name="type" value="create">
                    <!-- campo oculto para validar  -->

                    <input type="hidden" name="movies_id" value="<?=$movie->id?>">
                    <!-- id do movie -->

                    <div class="form-group">
                        <label for="rating">Nota do filme:</label>
                        <select name="rating" id="rating" class="form-control">
                            <option value="0">Selecione</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="review">Seu comentário:</label>
                        <textarea name="review" id="review" class="form-control" placeholder="Digite seu comentário"></textarea>
                    </div>

                    <input type="submit" class="btn card-btn" value="Enviar">
                </form>
            </div>

            <?php endif;?>
            
            <!-- SE HOUVER COMENTÁRIOS -->
            <?php if(count($moviesReview) > 0):?>
                <!-- PERCORRE O ARRAY COM AS REVIEWS -->
                <?php 
                    foreach($moviesReview as $review):
                ?>
                <!-- template de review -->
                <?php 
                    require("templates/user_review.php");
                ?>
                <?php endforeach;?>
            <?php else:?>
                <!-- SE NÃO TIVER REVIEWS -->
                <p class="empty-list">Não há reviews neste filme...</p>
            <?php endif?>   
            

            

        </div>
    </div>
</div>

<?php 
    include_once("templates/footer.php");
?>