<!-- classe dao que irá trabalhar com a persistência dos dados no banco -->

<?php 
    include_once("models/Review.php");
    include_once("models/Message.php");
    
    include_once("dao/UserDAO.php");

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
            $reviewObject = new Review();
            
            $reviewObject->id = $data['id'];
            $reviewObject->rating = $data['rating'];
            $reviewObject->review = $data['review'];
            $reviewObject->users_id = $data['users_id'];
            $reviewObject->movies_id = $data['movies_id'];

            return $reviewObject;
        }

        // criar um review 
        public function create(Review $review){
            $stmt = $this->conn->prepare("INSERT INTO reviews(rating,review,users_id,movies_id)
            values(:rating,:review,:users_id,:movies_id)
            ");
            $stmt->bindParam(":rating", $review->rating);
            $stmt->bindParam(":review", $review->review);
            $stmt->bindParam(":users_id", $review->users_id);
            $stmt->bindParam(":movies_id", $review->movies_id);


            $stmt->execute();

            if($stmt->rowCount()>0){
                $this->message->setMessage("Avaliação adicionada com sucesso", "sucess", "back");
            }
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