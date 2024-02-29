<!-- CLASSE DAO, UM PADRÃO DE ACESSO/PERSISTÊNCIA DE DADOS,
SERVE COMO UMA ABSTRAÇÃO DO MODELO DE DADOS.
OU SEJA, SUA FUNÇÃO É SEPARAR A LÓGICA DE ACESSO À DADOS DA LÓGICA
DE NEGÓCIOS. -->

<?php 
    require_once("models/User.php");
    require_once("models/Message.php");

    class UserDAO implements UserDAOInterface{
        private $conn; //conexão do banco
        private $url; // url : BASE URL
        private $message;

        // inicializando
        public function __construct(PDO $conn, $url)
        {
            $this->conn = $conn;
            $this->url = $url;
            $this->message = new Message($url);
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
       
        // criando user no banco
        public function create(User $user, $authUser = false){

            $stmt = $this->conn->prepare("INSERT INTO users(name, lastname, email, password, token)VALUES(:name,:lastname,:email, :password, :token)");
            
            $stmt->bindParam(":name", $user->name);
            $stmt->bindParam(":lastname", $user->lastname);
            $stmt->bindParam(":email", $user->email);
            $stmt->bindParam(":password", $user->password);
            $stmt->bindParam(":token", $user->token);
            
            $stmt->execute();


            // autentificar user
            if($authUser){
                $this->setTokenToSession($user->token, TRUE, $user->name);
                // Armazenando o token em sessão, mandando a autentificação true e o nome do usuario
            }

        }
        
        // atualizando usuário
        public function update(User $user){}

        // verificando token
        public function verifyToken($protected = false){}

        // login / redirect é para redirecionar
        public function setTokenToSession($token, $redirect = true, $name){
            // salvar token na sessão
            $_SESSION['token'] = $token;

            // redirecionar o usuário
            var_dump($redirect);
            if($redirect){
                // redireciona para o perfil
                $this->message->setMessage("Seja bem vindo, $name", "sucess", "editprofile.php");
            }
        }

        public function authenticateUser($email, $password){}

        // localizando user por email
        public function findByEmail($email){
            if($email!=""){
                $stmt = $this->conn->prepare("SELECT * from users WHERE email = :email");
                $stmt->bindParam(":email", $email);
                $stmt->execute();

                if($stmt->rowCount()>0){
                    // achou usuário
                    $data = $stmt->fetch();//pegando um resultado encontrado
                    $user = $this->buildUser($data);//chamando a função que constroi um usuário com base nos registros encontrados no bd

                    return $user;
                }else{
                    // não achou
                    return false;
                }



            }else{
                return false;
            }
        }

        public function findById($id){}

        // localizando por token
        public function findByToken($token){}

        public function changePassword(User $user){}

    }
    



?>