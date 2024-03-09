<?php 

class Movie{
    public $id;
    public $title;
    public $description;
    public $image;
    public $trailer;
    public $category;
    public $length;
    public $users_id;

    public function __construct()
    {
        
    }

    public function generateImageName(){
        return bin2hex(random_bytes(60)). "jpg";
    }
}

// interface que irá controlar o DAO. Esboço de métodos abaixo deverá ser implementados na classe DAO.
interface MovieDaoInterface{
    // construindo um objeto de movie com base nos dados recebidos
    public function buildMovie($data);

    // pega todos os filmes do banco
    public function findAll();

    // pegar os filmes inseridos mais recentementes : ou seja, decrescente
    public function getLatestMovie();

    // pegar os filmes por categoria
    public function getMoviesByCategory($category);

    // pegar os fillmes de um usuário específico
    public function getMoviesByUserId($id);

    // pegando um filme por id
    public function findById($id);

    // pegando um filme por title
    public function findByTitle($title);

    // registrando um filme
    public function create(Movie $movie);
    
    // atualizando um filem
    public function update(Movie $movie);

    // deletar um filme
    public function destroy(Movie $movie);

}


?>