<?php 
    // alterações de usuário
    require_once("models/User.php");
    // incluindo o modelo de user

    require_once("dao/UserDAO.php");
    // incluindo a abstração de acesso/persistência de dados

    require_once("globals.php"); 
    // incluindo BASEURL

    require_once("db.php");
    // incluindo banco

    require_once("models/Message.php");
    // incluindo a classe de msg


    // instanciando a classe msg
    $message = new Message($BASE_URL);

    // instanciando dao
    $userDao = new UserDAO($conn, $BASE_URL);

    $type = filter_input(INPUT_POST, "type");
    // o hidden que vem dos forms

    // atualizaçaõ de dados
    if($type==="update"){
        // verifica o token e resgata os dados do usuário se localizar. Retorna um obj
        $userData = $userDao->verifyToken();

        // receber dados do post
        $name = filter_input(INPUT_POST, "name");
        $lastname = filter_input(INPUT_POST, "lastname");
        $email = filter_input(INPUT_POST, "email");
        $bio = filter_input(INPUT_POST, "bio");
    
        // obj para trabalhar com a geração de nome da imagem abaixo
        $user = new User();


        // Passamos os dados que serão modificados
        $userData->name = $name;
        $userData->lastname = $lastname;
        $userData->email = $email;
        $userData->bio = $bio;
        // observe que estamos atualizado os dados em um objeto já existente o userData.


        // uploud da img
        if(isset($_FILES['image']) && !empty($_FILES['image']['tmp_name'])){
            //(isset) verifica se a superglobal files está/foi definida e é diferente de null. Além disso, verifica se há um arquivo pelo nome, no caso, o tmp_name
            
            $image = $_FILES['image'];
            $imageTypes = ["image/jpeg", "image/jpg", "image/png"]; //tipos de imagens permitidas
            $jpgArray = ["image/jpeg", "image/jpg"];

            
            // checagem de tipo. A função in_array() em PHP verifica se um determinado valor está presente em um array. Ela retorna true se o valor estiver presente no array e false caso contrário. in_array($array, $tipos)
            if(in_array($image['type'], $imageTypes)){
                // se encontrou os tipos permitidos
                // verificar os tipos específicos de imagem : jpeg / jpg
               
                if(in_array($image['type'], $jpgArray)){
                   
                    $imageFile = imagecreatefromjpeg($image['tmp_name']);
                    // A função imagecreatefromjpeg() cria uma imagem PHP a partir de um arquivo JPEG existente (o arquivo que veio na superglobal), ou seja, ela cria uma representação interna da imagem no PHP que pode ser manipulada. Essa função não cria um arquivo de imagem no disco.
                   

                }else{
                    // image png
                    
                    $imageFile = imagecreatefrompng($image["tmp_name"]);
                    // criando uma imagem do tipo png
                }

                // gerando o nome da img
                $imageName = $user->imageGenerateName();

                 // Criar uma nova imagem em branco para a miniatura com as dimensões desejadas (150x150)
                $miniatura = imagecreatetruecolor(150, 150);

                 // Redimensionar a imagem original para se ajustar à miniatura
                imagecopyresampled($miniatura, $imageFile, 0, 0, 0, 0, 150, 150, imagesx($imageFile), imagesy($imageFile));

                // NOTA: PARA USAR A FUNÇÃO IMAGEJPEG É NECESSÁRIO HABILITAR NO PHP.INI. TEM QUE TIRAR O ; = ;extension=gd 
                imagejpeg($miniatura, "./image/users/". $imageName, 100);
                // A função imagejpeg() é usada para salvar a imagem criada ou manipulada no PHP como um arquivo JPEG no disco.
                $userData->image = $imageName;


            }else{
                $message->setMessage("Insira uma imagem válida : [jpg/jpeg/png]", "error", "editprofile.php");
                
            }
        }

        $userDao->update($userData);
        //o método update exige outros camps, como token. No entanto, como estamos reaproveitando o objeto já existente (userData) apenas passamos os dados que queremos alterar. 


    }else if($type === "changepassword"){
        // atualizando senha
        $password = filter_input(INPUT_POST, "password");
        $confirmpassword = filter_input(INPUT_POST, "confirmpassword");
        var_dump($_POST);
    }else{
        $message->setMessage("Informações inválidas", "error", "index.php");
    }

?>