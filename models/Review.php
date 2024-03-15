<?php 
    // classe review 
    class Review{
        public $id;
        public $rating;
        public $review;
        public $users_id;
        public $movies_id;
    }

    // interface que irá  mandar no DAO de persitência
    interface ReviewDaoInterface{
        // construindo o objeto review
        public function buildReview($data);

        // criar um review 
        public function create(Review $review);

        // retorna todos os review de um filme por id
        public function getMoviesReview($id);

        // verificando se o user já fez uma review
        public function hasAlreadyReviewed($id, $userId);

        // buscando todas as notas de um filme
        public function getRating($id);
    }
?>