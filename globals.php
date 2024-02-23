<?php 
    session_start();

    $BASE_URL = "http://".$_SERVER['SERVER_NAME'].dirname($_SERVER['REQUEST_URI'] . "?") . "/";
    // essa linha de código está construindo a URL base do site concatenando o protocolo, o nome do servidor, o diretório pai da URI requisitada e uma barra no final para indicar o diretório raiz
    
    

?>