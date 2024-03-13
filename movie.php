<!-- visualizar o filme -->
<?php 
    include_once("templates/header.php");
    // verificação se usuário está autentificado
    include_once("dao/MovieDao.php");
    include_once("models/Movie.php");


    // pegar o id do filme
    $id = filter_input(INPUT_GET, "id");

    $movie;

    if(!empty($id)){
        $movieDao = new MovieDao($conn, $BASE_URL);
        // verificando se o filme existe por id
        $movie = $movieDao->findById($id);
        
        if($movie == null){
            $message->setMessage("Null: Filme não localizado", "error", "index.php");
        }else{
            var_dump($movie);
        }

    }else{
        $message->setMessage("Filme não localizado", "error", "index.php");
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

    // RESGATANDO AS REVIEWS DO FILME
?>

<?php 
    include_once("templates/footer.php");
?>