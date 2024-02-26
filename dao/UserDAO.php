<!-- CLASSE DAO, UM PADRÃO DE ACESSO/PERSISTÊNCIA DE DADOS,
SERVE COMO UMA ABSTRAÇÃO DO MODELO DE DADOS.
OU SEJA, SUA FUNÇÃO É SEPARAR A LÓGICA DE ACESSO À DADOS DA LÓGICA
DE NEGÓCIOS. -->

<?php 
    require_once("models/User.php");

    class UserDAO implements UserDAOInterface{
        private $conn; //conexão do banco
        private $url; // url : BASE URL

        // inicializando
        public function __construct(PDO $conn, $url)
        {
            $this->conn = $conn;
            $this->url = $url;
        }


         // construir o objeto de usuário
        public function buildUser($data){
            $user = new User(); //instanciando um obj User com base no model/User
            $user->id = $data['id'];//acessando as props do objeto user e passando dados
            $user->name = $data['name'];
            $user->lastname = $data['lastname'];
            $user->email = $data['email'];
            $user->password = $data['password'];
            $user->image = $data['image'];
            $user->bio = $data['bio'];
            $user->token = $data['token'];     

            return $user; //retornando o objeto criado
        }
       

        public function create(User $user, $authUser = false){}
        
        // atualizando usuário
        public function update(User $user){}

        // verificando token
        public function verifyToken($protected = false){}

        // login / redirect é para redirecionar
        public function setTokenToSession($tolen, $redirect = true){}

        public function authenticateUser($email, $password){}

        // localizando user por email
        public function findByEmail($email){}

        public function findById($id){}

        // localizando por token
        public function findByToken($token){}

        public function changePassword(User $user){}

    }
    



?>