<?php 
    include_once("models/Movie.php");//nossa classe principal
    include_once("models/Message.php");// classe voltada para mensagens de erro

    class MovieDao implements MovieDaoInterface{
        // construindo um objeto de movie com base nos dados recebidos

        private $url;
        private $conn;
        private $message;

        public function __construct(PDO $conn, $url)
        {
            $this->url = $url;
            $this->conn = $conn;
            $this->message = new Message($url);
        }

        // construindo um objeto de movie com base nos dados do array de dados
        public function buildMovie($data){
            $movie = new Movie();    

            $movie->id = $data['id'];
            $movie->title = $data['title'];
            $movie->description = $data['description'];
            $movie->image = $data['image'];
            $movie->trailer = $data['trailer'];
            $movie->category = $data['category'];
            $movie->length = $data['length'];
            $movie->users_id = $data['users_id'];

            return $movie;
        }

        // pega todos os filmes do banco
        public function findAll(){

        }

        // pegar os filmes inseridos mais recentementes : ou seja, decrescente
        public function getLatestMovie(){
            $movies = []; // array que irá armazenar os resultados obtidos do banco

            $stmt = $this->conn->query("SELECT * FROM movies ORDER BY id desc");
            $stmt->execute();

            if($stmt->rowCount()>0){
                $movieArray = $stmt->fetchAll();

                foreach($movieArray as $movie){ 
                    // movies irá armazenar um array de objetos.
                    $movies[] = $this->buildMovie($movie);
                }
            }
            return $movies;
        }

        // pegar os filmes por categoria
        public function getMoviesByCategory($category){
            $movies = [];

            $stmt = $this->conn->prepare("SELECT * FROM movies WHERE category=:category ORDER BY id desc");
            $stmt->bindParam(":category", $category);
            $stmt->execute();

            if($stmt->rowCount()>0){
                $movieAction = $stmt->fetchAll();
                // array que armazenará todos os dados localizados na tabela com base na categoria
                
                foreach($movieAction as $m){
                    $movies[] = $this->buildMovie($m);
                    // array armazenará os objetos do tipo da categoria de filme (que serão criados com base nos dados passados)
                }
            }

            // var_dump($movies);exit;
            return $movies;//retorna o array de objetos

        }

        // pegar os fillmes de um usuário específico
        public function getMoviesByUserId($id){
            $arrMovie = [];

            $stmt = $this->conn->prepare("SELECT * FROM movies WHERE users_id=:users_id");
            $stmt->bindParam(":users_id", $id);
            $stmt->execute();

            if($stmt->rowCount()>0){
                $moviesByUser = $stmt->fetchAll();
                
                foreach($moviesByUser as $movies){
                    $arrMovie[] = $this->buildMovie($movies);
                    // o array irá armanezar uma série de objetos
                }
            }else{
                $arrMovie = null;
            }
            return $arrMovie;
            // retorna o array com os objetos


        }

        // pegando um filme por id
        public function findById($id){
            $movie = null;

            $stmt = $this->conn->prepare("SELECT * FROM movies WHERE id =:id");
            $stmt->bindParam(":id", $id);
            $stmt->execute();

            if($stmt->rowCount()>0){
                $m = $stmt->fetch();
                $movie = $this->buildMovie($m);

                return $movie;
            }
           
        }

        // pegando um filme por title
        public function findByTitle($title){

        }

        // registrando um filme no banco
        public function create(Movie $movie){
            $stmt = $this->conn->prepare("INSERT INTO movies(title, description, image, trailer,category, length, users_id)VALUES(
                :title, :description, :image, :trailer, :category, :length, :users_id
            )");

            $stmt->bindParam(":title", $movie->title);
            $stmt->bindParam(":description", $movie->description);
            $stmt->bindParam(":image", $movie->image);
            $stmt->bindParam(":trailer", $movie->trailer);
            $stmt->bindParam(":category", $movie->category);
            $stmt->bindParam(":length", $movie->length);
            $stmt->bindParam(":users_id", $movie->users_id);

            $stmt->execute();

            if($stmt->rowCount()>0){
                $this->message->setMessage("Filme registrado com sucesso", "sucess", "index.php");
            }
        }
        
        // atualizando um filme
        public function update(Movie $movie){

        }

        // deletar um filme
        public function destroy(Movie $movie){

        }

    }
?>