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


         // construir o objeto de usuário com base nos dados do banco
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
       
        //cria um usuário. O argumento $authUser é para quando o usuário se cadastrar, ele já logar em seguinda. Ele inicia como false
        public function create(User $user, $authUser = false){

            $stmt = $this->conn->prepare("INSERT INTO users(name, lastname, email, password, token)VALUES(:name,:lastname,:email, :password, :token)");
            
            $stmt->bindParam(":name", $user->name);
            $stmt->bindParam(":lastname", $user->lastname);
            $stmt->bindParam(":email", $user->email);
            $stmt->bindParam(":password", $user->password);
            $stmt->bindParam(":token", $user->token);
            
            $stmt->execute();


            // autentificar caso o auth seja true
            if($authUser){
                $this->setTokenToSession($user->token, TRUE, $user->name);
                // Armazenando o token em sessão, mandando a autentificação true e o nome do usuario
            }

        }
        
        // atualizando usuário
        public function update(User $user, $redirect = true){
            $stmt = $this->conn->prepare("UPDATE users SET 
                name = :name,
                lastname = :lastname,
                email = :email,
                image = :image,
                bio = :bio,
                token= :token
                WHERE id = :id
            ");

            $stmt->bindParam(":name",$user->name);
            $stmt->bindParam(":lastname",$user->lastname);
            $stmt->bindParam(":email",$user->email);
            $stmt->bindParam(":image",$user->image);
            $stmt->bindParam(":bio",$user->bio);
            $stmt->bindParam(":token",$user->token);
            $stmt->bindParam(":id",$user->id);

            $stmt->execute();
            $name = $user->name;

            if($redirect){
                // redireciona para o perfil
                $this->message->setMessage("Dados atualizados com sucesso.", "sucess", "editprofile.php");
            }else{
                $this->message->setMessage("Bem vindo, $name.", "sucess", "editprofile.php");
            }

        }

        // verificando token
        public function verifyToken($protected = false){
            // O protected vem false como padrão. Porém, quisermos proteger a página, ou seja, permitir que ela seja acessada apenas se tiver logado, passamos true ao  chamar essa funçaõ.
            if(!empty($_SESSION['token'])){
                // pega o token da session
                $token = $_SESSION['token'];

                $user = $this->findByToken($token);//verifica se o token é valido ou seja, existente. Retorna um objeto se localizar 

                if($user){//se for encontrado
                    return $user;//retorna um objeto
                }else if($protected){
                    // redireciona user n autenticado. Se o usuário não for encontrado com base no token
                    $this->message->setMessage("Faça a autentificação para acessar essa página", "error", "index.php");
                }

            }else if($protected){
                // se cair aqui, a sessão token está vazia e significa que o user está tentando bular a url.

                $this->message->setMessage("Faça a autentificação para acessar essa página...", "error", "index.php");
            }
        }

        // login / redirect é para redirecionar
        public function setTokenToSession($token, $redirect = true, $name){
            // salvar token na sessão
            $_SESSION['token'] = $token;

            // redirecionar o usuário
            if($redirect){
                // redireciona para o perfil
                $this->message->setMessage("Seja bem vindo, $name", "sucess", "editprofile.php");
            }
        }

        public function authenticateUser($email, $password){
            $user = $this->findByEmail($email);
            // verifica se existe um e-mail. Se existir, retorna um objeto do banco com todos os dados, ou seja, um true. Se não existir, retorna false
          
            if($user){
                //o retorno de um objeto é equivalente ao true na condição
                
                // verificar senhas
                if(password_verify($password, $user->password)){
                     // password_verify é um algoritmo que verifica as hash. Passamos a senha digitada e compara com o banco
                    
                    //gerar token um novo token
                    $token = $user->generateToken();

                    // joga o token na sessão
                    $this->setTokenToSession($token, false, $user->name);
                    
                    // seta o token no objeto usuário
                    $user->token = $token;

                    // atualiza o novo token do usuário no banco
                    // $this->update($user, false);//atualizar 
                    $this->updateToken($user);                 
                   
                    return true;

                }else{
                    return false;
                } 
            }else{
                return false;
            }
    

        }

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

        public function findById($id){
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE id=:id");
            $stmt->bindParam(":id",$id);
            $stmt->execute();

            if($stmt->rowCount()>0){
                $user = $stmt->fetch();
                return $this->buildUser($user);
                // construindo um objeto e retornando
            }

        }

        // localizando por token
        public function findByToken($token){
            if(!empty($token)){
                $stmt = $this->conn->prepare("SELECT * FROM users where token=:token");

                $stmt->bindParam(":token", $token);
                $stmt->execute();

                if($stmt->rowCount()>0){
                    $data = $stmt->fetch();
                    $user = $this->buildUser($data);

                    return $user;//retorna um objeto de usuário com base no token
                }else{
                    return false;// significa que o token passado é inválido
                }

            }else{
                return false;
            }
        }

        // modificando password
        public function changePassword(User $user){
            $stmt = $this->conn->prepare("UPDATE users SET 
            password =:password WHERE id=:id");

            $stmt->bindParam(":password", $user->password);
            $stmt->bindParam(":id", $user->id);
            $stmt->execute();

            $this->message->setMessage("Senha alterada com sucesso", "sucess", "back");
        }

        public function destroyToken(){
            // remove o token da sessão
            $_SESSION['token'] = "";

            // redirecionar
            $this->message->setMessage("Logout com sucesso.", "sucess", "index.php");

        }

        public function updateToken(User $user){
            
            $stmt = $this->conn->prepare("UPDATE users SET token =:token WHERE id=:id");
            $stmt->bindParam(":token", $user->token);
            
            $stmt->bindParam(":id", $user->id);
            $stmt->execute();

            $name = $user->name;
            
            $this->message->setMessage("Bem vindo, $name", "sucess", "editprofile.php");            

            return true;
        }

    }
    



?>