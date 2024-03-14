<?php 
    include_once("templates/header.php");
    include_once("dao/UserDAO.php");
    include_once("dao/MovieDao.php");

    include_once("models/User.php");

    $userDao = new UserDAO($conn, $BASE_URL);
    $movieDao = new MovieDao($conn, $BASE_URL);

    $userData = $userDao->verifyToken(true);
    // true porque, se o usuário estiver deslogado, será redirecionado para outra página

    // validação do filme
    if(empty(filter_input(INPUT_GET, 'id'))){
        $message->setMessage("Filme não localizado", "error", "index.php");
    }else{
        $movie = $movieDao->findById(filter_input(INPUT_GET, 'id'));

        if($movie->users_id === $userData->id){
            // evitando que o usuário tente editar um filme que não é dele. I
        }else{
            $message->setMessage("Filme não localizado...", "error", "dashboard.php");
        }
    }

    // VERIFICANDO SE O FILME TEM IMAGEM
    if($movie->image == ""){
        $movie->image = "movie_cover.jpg";
    }



?>

<div id="main-container" class="container-fluid">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6 offset-md-1">
                <h1><?=$movie->title?></h1>
                <p class="page-description">Altere os dados do filme</p>

                <form id="edit-movie-form" action="<?=$BASE_URL?>movie_process.php" method="post" enctype="multipart/form-data">
               
                <input type="hidden" name="type" value="update">
                <!-- campo indicando que é um update -->
                <input type="hidden" name="id" value="<?=$movie->id?>">
                <!-- id que o usuário está modificando -->
                <div class="form-group">
                    <label for="title">Titulo:</label>
                    <input type="text" class="form-control" name="title" id="title" placeholder="Digite o nome do filme" value="<?=$movie->title?>">
                </div>

                <div class="form-group">
                    <label for="image">Imagem:</label>
                    <input type="file" class="form-control-file" name="image" id="image">
                </div>

                <div class="form-group">
                    <label for="length">Duração:</label>
                    <input type="text" class="form-control" name="length" id="length" placeholder="Digite a duração do filme" value="<?=$movie->length?>">
                </div>

                <div class="form-group">
                    <label for="category">Categoria:</label>
                    <select name="category" id="category" class="form-control" >
                        <option value="Selecionar">Selecionar</option>
                        <option value="Ação" <?=$movie->category === 'Ação' ? 'selected' : ''?>>Ação</option>
                        <option value="Drama"  <?=$movie->category === 'Drama' ? 'selected' : ''?>>Drama</option>
                        <option value="Comédia" <?=$movie->category === 'Comédia' ? 'selected' : ''?>>Comédia</option>
                        <option value="Ficção" <?=$movie->category === 'Ficção' ? 'selected' : ''?>>Ficção</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="trailer">Trailer:</label>
                    <input type="text" class="form-control" name="trailer" id="trailer" placeholder="Insira o link do trailer" value="<?=$movie->trailer?>">
                </div>

                <div class="form-group">
                    <label for="description">Descrição:</label>
                    <textarea name="description" id="description" rows="5" placeholder="Adicione a descrição" class="form-control"><?=$movie->description?></textarea>
                </div>

                <input type="submit" class="btn card-btn" value="Adicionar filme">

                </form>
            </div>

            <div class="col-md-3">
                <div class="movie-image-container2" style="background-image: url('<?=$BASE_URL?>image/movies/<?=$movie->image?>');"></div>
            </div>
        </div>
    </div>
</div>

<?php
include_once("templates/footer.php");
?>