<?php
    include_once("templates/header.php");
    include_once("dao/UserDAO.php");
    include_once("models/User.php");

    $userDao = new UserDAO($conn, $BASE_URL);

    $userData = $userDao->verifyToken(true);
    // o argumento é true justamente para o caso do usuário tentar bular a url.Ou seja, não há uma sessão de token para autentificação. Retorna um objeto usuário se localizar

    $user = new User();
    $fullName = $user->getFullName($userData);

    if($userData->image == ""){
        $userData->image = "user.png";
    }


?>
<div id="main-container" class="container-fluid">
    <div class="col md-12">
        <form action="<?=$BASE_URL?>user_process.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="type" value="update">

            <div class="row">
                <div class="col-md-4">
                    <h1><?=$fullName?></h1>
                    <p class="page-description">Altere seus dados no formulário abaixo:</p>

                    <div class="form-group">
                        <label for="name">Nome:</label>
                        <input type="text" class="form-control" name="name" id="name" value="<?=$userData->name?>">
                    </div>

                    <div class="form-group">
                        <label for="lastname">Sobrenome:</label>
                        <input type="text" class="form-control" name="lastname" id="lastname" value="<?=$userData->lastname?>">
                    </div>

                    <div class="form-group">
                        <label for="email">E-mail:</label>
                        <input type="email" class="form-control disabled" name="email" id="email" value="<?=$userData->email?>" readonly>
                    </div>

                    <input type="submit" class="btn form-btn" value="Alterar">
                </div>

                <div class="col-md-4">
                    <!-- img -->
                    <div id="profile-image-container" style="background-image: url('<?=$BASE_URL?>image/users/<?=$userData->image?>')"></div>

                    <div class="form-group">
                        <label for="imagem">Foto:</label>
                        <input type="file" class="form-control-file" name="image" id="imagem">
                    </div>

                    <div class="form-group">
                        <label for="bio">Sobre você:</label>
                        <textarea name="bio" id="bio" rows="5" class="form-control" placeholder="Conte mais sobre você"></textarea>
                    </div>
                </div>                
            </div>
        </form>
    </div>
</div>

<?php
    include_once("templates/footer.php");
?>