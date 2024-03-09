<?php
    include_once("templates/header.php");
    // verificação se usuário está autentificado
    include_once("dao/UserDAO.php");
    include_once("models/User.php");

    $userDao = new UserDAO($conn, $BASE_URL);

    $userData = $userDao->verifyToken(true);
    // true porque, se o usuário estiver deslogado, será redirecionado para outra página

?>
<div id="main-container" class="container-fluid">
    <div class="offset-md-4 col-md-4 new-movie-container">
        <h1 class="page-title">Adicionar filme</h1>
        <p class="page-description">Adicione sua critica</p>

        <form action="<?=$BASE_URL?>movie_process.php" id="add-movie-form" enctype="multipart/form-data" method="post" >
            <input type="hidden" name="type" value="create">

            <div class="form-group">
                <label for="title">Titulo:</label>
                <input type="text" class="form-control" name="title" id="title" placeholder="Digite o nome do filme">
            </div>

            <div class="form-group">
                <label for="image">Imagem:</label>
                <input type="file" class="form-control-file" name="image" id="image">
            </div>

            <div class="form-group">
                <label for="length">Duração:</label>
                <input type="text" class="form-control" name="length" id="length" placeholder="Digite a duração do filme">
            </div>

            <div class="form-group">
                <label for="category">Categoria:</label>
                <select name="category" id="category" class="form-control">
                    <option value="">Selecione</option>
                    <option value="Ação">Ação</option>
                    <option value="Drama">Drama</option>
                    <option value="Comédia">Comédia</option>
                    <option value="Ficção">Ficção</option>
                </select>
            </div>

            <div class="form-group">
                <label for="trailer">Trailer:</label>
                <input type="text" class="form-control" name="trailer" id="trailer" placeholder="Insira o link do trailer">
            </div>

            <div class="form-group">
                <label for="description">Descrição:</label>
                <textarea name="description" id="description" rows="5" placeholder="Adicione a descrição" class="form-control"></textarea>
            </div>

            <input type="submit" class="btn card-btn" value="Adicionar filme">
        </form>
    </div>
</div>

<?php
include_once("templates/footer.php");
?>