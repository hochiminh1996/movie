<?php
    include_once("templates/header.php");
    include_once("dao/UserDAO.php");

    $userDao = new UserDAO($conn, $BASE_URL);

    $userData = $userDao->verifyToken(true);
    // o argumento é true justamente para o caso do usuário tentar bular a url.Ou seja, não há uma sessão de token para autentificação



?>
<div id="main-container" class="container-fluid">
    <h1>Entrou</h1>
</div>

<?php
    include_once("templates/footer.php");
?>