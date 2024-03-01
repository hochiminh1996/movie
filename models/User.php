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


        public function generateToken(){
            // A função bin2hex converte dados binários (não precisa necessariamente ser binario, pode ser strings) em uma representação hexadecimal. No exemplo abaixo, ele cria uma string alaetória de 50 caracteres e depois converte para hex. Ou seja, não haverá a possibilidade de gerar dois token iguais.
           return bin2hex(random_bytes(50));     
        }

        public function generatePassword($password){
            return password_hash($password, PASSWORD_DEFAULT);
            // vai criar um hash de senha com base na senha informada pelo usuário. PASSWORD_DEFAULT é o tipo de hash padrão do php

            // A função password_hash  é usada para criar um hash de senha segura usando um algoritmo de hash de senha forte


            // Um hash é uma função matemática que transforma dados de entrada (como uma string de texto ou um arquivo) em uma sequência de caracteres alfanuméricos de tamanho fixo, geralmente representada como uma sequência hexadecimal. 
        }

        public function getFullName($user){
            return $user->name. " ". $user->lastname;
        }

    }


    // interface definindo os métodos que deverão ser implementados na DAO
    interface UserDAOInterface{
        public function buildUser($data);
        // construir o objeto com base em dados fornecidos. O $data será um array

        public function create(User $user, $authUser = false);
        
        // atualizando usuário
        public function update(User $user,  $redirect);

        // verificando token
        public function verifyToken($protected = false);

        // login / redirect é para redirecionar
        public function setTokenToSession($tolen, $redirect = true, $name);

        public function authenticateUser($email, $password);

        // localizando user por email
        public function findByEmail($email);

        public function findById($id);

        // localizando por token
        public function findByToken($token);

        public function changePassword(User $user);
        
        public function destroyToken();

    }

?>