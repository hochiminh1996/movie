<!-- classe dao que irá trabalhar com a persistência dos dados no banco -->

<?php 
    include_once("models/Review.php");
    include_once("models/Message.php");

    class ReviewDao implements ReviewDaoInterface{
        private $conn;
        private $url;
        private $message;

        public function __construct(PDO $conn, $url)
        {
            $this->conn = $conn;
            $this->url = $url;
            $this->message = new Message($url);
        }

        // construindo o objeto review
        public function buildReview($data){
            
        }

        // criar um review 
        public function create(Review $review){
            
        }

        // retorna todos os review de um filme por id
        public function getMoviesReview($id){
            
        }

        // verificando se o user já fez uma review
        public function hasAlreadyReviewed($id, $userId){
            
        }

        // buscando todas as notas de um filme
        public function getRating($id){
            
        }
    }

?>