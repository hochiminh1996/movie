<!-- perfils de usuários -->
<?php 
    include_once("templates/header.php");
    include_once("dao/UserDAO.php");
    include_once("models/User.php");
    include_once("dao/MovieDao.php");

    $user = new User();
    $userDao = new UserDAO($conn, $BASE_URL);
    $movieDao = new MovieDao($conn, $BASE_URL);

    // Pegando id do usuário
    $id = filter_input(INPUT_GET, "id");

    // observação : o userData está vindo do header
    if(empty($id)){
        // se não vier nada do get, iremos atribuir o id do usuário logado. O html irá mostrar o perfil do usuário que estiver logado, com base no userData e seus dados
        if(!empty($userData->id)){// Se a propr id do obj não estiver vazio.
            $id = $userData->id;// setando o valor do id do obj na variável. Ou seja, do proprio perfil de quem estiver logado.


        }else{
            // se não tiver id, e não tiver usuário, lançar erro. Não logado
            $message->setMessage("Usuário não encontrado", "error", "index.php");
        }
    }else{
        // se vier um id 
        $userData = $userDao->findById($id);
        // buscando os dados por id: retorna um objeto

        // se não localizar o usuário
        if(!$userData){
            $message->setMessage("Usuário não encontrado.", "error", "index.php");
        }

    }

    // nome completo do usuário
    $fullName = $user->getFullName($userData);


    // se o user não tiver imagem
    if($userData->image==""){
        // se não tiver imagem
        $userData->image="user.png";
    }

    // filmes que o usuario adicionou
    $userMovies = $movieDao->getMoviesByUserId($userData->id);


?>
<div id="main-container" class="container-fluid">
    <div class="col-md-8 offset-md-2">
        <div class="row profile-container">
            <div class="col-md-12 about-container">
                <h1 class="page-title"><?=$fullName?></h1>

                <div id="profile-image-container" class="profile-image" style="background-image: url(<?=$BASE_URL?>image/users/<?=$userData->image?>);">
                </div>

                <h3 class="about-title">Sobre:</h3>

                <!-- se tiver bio -->
                <?php 
                    if(!empty($userData->bio)):
                ?>
                    <p class="profile-description"><?=$userData->bio?></p>
                
                <?php else:?>
                    <!--  se não tiver bio -->
                    <p class="profile-description">[Sem bio]</p>

                <?php endif;?>    
            </div>

        
            <div class="col-md-12 added-movies-container">
                <h3>Filmes inseridos por <?=$userData->name?></h3>
                <div class="movies-container">
                    <!-- se naõ tiver movies -->
                    <?php if($userMovies == null):?>
                    <p class="empty-list">Usuário não adicionou nenhum filme.</p>

                    <?php else:?>
                        <!-- se tiver filmes -->
                        <?php 
                        foreach($userMovies as $movie):
                    ?>
                    <?php 
                            require("templates/movie_card.php");
                    ?>

                        <?php endforeach?>
                    <?php endif?>
                </div>                    
            </div>
        </div>
    </div>
</div>

<?php 
    include_once("templates/footer.php");
?>