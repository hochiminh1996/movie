<?php 
    class User{
        public $id;
        public $name;
        public $lastname;
        public $email;
        public $password;
        public $image;
        public $bio;
        public $token;

    }


    // interface definindo os métodos que deverão ser implementados na DAO
    interface UserDAOInterface{
        public function buildUser($data);
        // construir o objeto

        public function create(User $user, $authUser = false);
        
        // atualizando usuário
        public function update(User $user);

        // verificando token
        public function verifyToken($protected = false);

        // login / redirect é para redirecionar
        public function setTokenToSession($tolen, $redirect = true);

        public function authenticateUser($email, $password);

        // localizando user por email
        public function findByEmail($email);

        public function findById($id);

        // localizando por token
        public function findByToken($token);

        public function changePassword(User $user);

    }

?>