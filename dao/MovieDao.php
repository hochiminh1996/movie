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

        }

        // pegar os filmes por categoria
        public function getMoviesByCategory($category){

        }

        // pegar os fillmes de um usuário específico
        public function getMoviesByUserId($id){

        }

        // pegando um filme por id
        public function findById($id){

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
            $stmt->bindParam(":category", $movie->title);
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