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
                <tr>
                    <td scope="row"></td>
                    <td><a href="#" class="table-movie-title">Titulo</a></td>
                    <td><i class="fas fa-star"></i> 9</td>
                    <td class="actions-column">
                        <a href="" class="edit-btn">
                            <i class="far fa-edit"></i> Editar
                        </a>
                        
                        <form action="">
                            <button type="submit" class="delete-btn">
                                <i class="fas fa-times"></i> Deletar
                            </button>
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<?php
include_once("templates/footer.php");
?>