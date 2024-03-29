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
            $comment = [];//array com as reviews
            $stmt = $this->conn->prepare("SELECT * FROM reviews WHERE movies_id=:movies_id ORDER BY id DESC");
            $stmt->bindParam("movies_id", $id);
            $stmt->execute();

            if($stmt->rowCount()>0){
                $reviewMovies = $stmt->fetchAll();
                
                $userDao = new UserDAO($this->conn, $this->url);
                // chamando o dao para buscar os dados do usuário que adicionou o filme

                foreach($reviewMovies as $reviews){

                    $reviewObject = $this->buildReview($reviews);
                    // reviewObject armazena um objeto. Observe q estamos criando um objeto partir de dados de um array
                    
                    // Buscando os dados do usuário que adicionou o review
                    $user = $userDao->findById($reviewObject->users_id);


                    $reviewObject->user = $user;
                    // Foi criado uma prop. em reviewObject (->user) que irá armazenar o objeto do usuário que adicionou o filme
                   

                    $comment[] = $reviewObject;
                    // um array que irá armazenar vários objetos de review, além de uma prop. que irá conter os dados do usuário que fez o review
                }
            }

            // var_dump($comment);exit;
            return $comment;//retorna um array de objetos

        }

        // verificando se o user já fez uma review
        // Só pode realizar uma review quem não adicionou o filme a ser comentado, não fez nenhuma review e está logado
        public function hasAlreadyReviewed($id, $userId){
            $stmt = $this->conn->prepare("SELECT * FROM reviews WHERE movies_id=:movies_id AND users_id=:users_id");
            $stmt->bindParam(":movies_id", $id);
            $stmt->bindParam(":users_id", $userId);
            $stmt->execute();

            if($stmt->rowCount()>0){
                return true;
            }else{
                return false;
            }
        }

        // buscando todas as notas de um filme
        public function getRating($id){
            $stmt = $this->conn->prepare("SELECT rating FROM reviews WHERE movies_id =:movies_id");
            $stmt->bindParam(":movies_id", $id);
            $stmt->execute();
            
            
            if($stmt->rowCount()>0){
                $soma=0;
                $ratings = $stmt->fetchAll();

                $sum = array_column($ratings, "rating");//pegando a coluna de rating das avaliações;

                return number_format(array_sum($sum) / count($sum), 2);
                // formata a nota, soma todas as notas e divide pela quantidade de array
                
            }else{
                return "Não avaliado";
            }
            
        }
    }

?>