<?php 
    include_once("templates/header.php");
    include_once("dao/UserDAO.php");
    include_once("models/User.php");
    include_once("dao/MovieDao.php");

    $userDao = new UserDAO($conn, $BASE_URL);
    $movieDao = new MovieDao($conn, $BASE_URL);

    $userData = $userDao->verifyToken(true);   
    // true porque, se o usuário estiver deslogado, será redirecionado para outra página

    $moviesByIdUser = $movieDao->getMoviesByUserId($userData->id);//retorna um array

?>
<div id="main-container" class="container-fluid">
    <h1 class="section-title">Dashboard</h1>
    <p class="section-description">Adicione ou atualiza as informações dos filmes</p>

    <div class="col-md-12" id="add-movie-container">
        <a href="<?=$BASE_URL?>newmovie.php" class="btn card-btn">
            <i class="fas fa-plus"></i> Adicionar filme
        </a>
    </div>
    <div class="col-md-12" id="movies-dashboard">
        <table class="table">
            <thead>
                <th scope="col">#</th>
                <th scope="col">Titulo</th>
                <th scope="col">Nota</th>
                <th scope="col" class="actions-column">Ações</th>
            </thead>

            <tbody>
                <?php 
                    foreach($moviesByIdUser as $movie):
                ?>
                <tr>
                    <td scope="row"><?=$movie->id?></td>
                    <td><a href="<?=$BASE_URL?>movie.php?id=<?=$movie->id?>" class="table-movie-title"><?=$movie->title?></a></td>
                    <td><i class="fas fa-star"></i> 9</td>
                    <td class="actions-column">
                        <a href="<?=$BASE_URL?>editmovie.php?id=<?=$movie->id?>" class="edit-btn">
                            <i class="far fa-edit"></i> Editar
                        </a>
                        
                        <form action="<?=$BASE_URL?>movie_process.php">
                            <input type="hidden" name="type" value="delete">

                            <!-- passando o id do movie -->
                            <input type="hidden" name="id" value="<?=$movie->id?>">

                            <button type="submit" class="delete-btn">
                                <i class="fas fa-times"></i> Deletar
                            </button>
                        </form>
                    </td>
                </tr>
                <?php 
                    endforeach;
                ?>
                
            </tbody>
        </table>
    </div>
</div>

<?php
include_once("templates/footer.php");
?>