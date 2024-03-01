<?php
include_once("templates/header.php");
?>
<div id="main-container" class="container-fluid">
    <div class="col-md-12">
        <div class="row" id="auth-row">
            <div class="col-md-4" id="login-container">
                <h2>Entrar</h2>
                
                <form action="<?=$BASE_URL?>auth_process.php" method="post">

                    <input type="hidden" value="login" name="type">
                    <!-- para identificar o tipo de dado que está sendo enviado. Por isso usamos esse campo hidden. Inclusive, estamos utilizando-o no registrar -->
                    
                    <div class="form-group">
                        <label for="email">E-mail:</label>
                        <input type="email" class="form-control" placeholder="Digite seu e-mail" id="email" name="email">
                    </div>

                    <div class="form-group">
                        <label for="password">Senha:</label>
                        <input type="password" class="form-control" placeholder="Digite sua senha" id="password" name="password">
                    </div>
                    <input type="submit" class="btn card-btn" value="Entrar">
                </form>
            </div>

            <div class="col-md-4" id="register-container">
                <h2>Criar Conta</h2>
                <form action="<?=$BASE_URL?>auth_process.php" method="post">
                <!-- observe que os dados serão direcionados para o arquivo auth_process -->
                    <input type="hidden" value="register" name="type">
                    <div class="form-group">
                        <label for="email_register">E-mail:</label>
                        <input type="email" class="form-control" placeholder="Digite seu e-mail" id="email_register" name="email">
                    </div>  

                    <div class="form-group">
                        <label for="name">Nome:</label>
                        <input type="text" class="form-control" placeholder="Digite seu nome" id="name" name="name">
                    </div>

                    <div class="form-group">
                        <label for="lastname">Sobrenome:</label>
                        <input type="text" class="form-control" placeholder="Digite seu sobrenome" id="lastname" name="lastname">
                    </div>

                    <div class="form-group">
                        <label for="password_register">Senha:</label>
                        <input type="password" class="form-control" placeholder="Digite sua senha" id="password_register" name="password">
                    </div>

                    <div class="form-group">
                        <label for="confirmpassword">Confirme a senha:</label>
                        <input type="password" class="form-control" placeholder="Confirme sua senha" id="confirmpassword" name="confirmpassword">
                    </div>
                    <input type="submit" class="btn card-btn" value="Registrar-se">
                </form>
            </div>
        </div>
    </div>
</div>

<?php
include_once("templates/footer.php");
?>