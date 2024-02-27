<?php 

    // delegação de funções ou separação de responsabilidades. Voltada para as msgs que aparecem o sys
    class Message{
        private $url;

        // $url irá receber o base url
        public function __construct($url)
        {
            $this->url = $url;
        }

        //recebe uma  msg, o tipo de msg e o redirecionamento ou não.
        public function setMessage($msg, $type, $redirect = "index.php"){
            // se o parâmetro redirect vier vazio, ele atribui ao valor de redirect = index.php. 

          $_SESSION['msg'] = $msg;//sessão com a msg
          $_SESSION['type'] = $type;//sessão com o tipo de msg

          if($redirect != "back"){
            // se for diferente de back, irá redirecionar para o index.php
            header("Location: $this->url". $redirect);
            
          }else{
            header("Location: ".$_SERVER['HTTP_REFERER']);
            // retorna para a página anterior
          }
          

        }

        public function getMessage(){

        }

        public function clearMessage(){

        }
    }

?>