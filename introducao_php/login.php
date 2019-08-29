<?php
    session_start(); 
    if(isset($_GET['logout'])){
       session_destroy();
       echo "Voce foi deslogado";
    }else if(isset($_SESSION["LOGIN"])){
      echo "Voce esta logado";
      
    }
    else if(isset($_POST['user']) && $_POST['user'] == "admin" 
    && isset($_POST['pass']) && $_POST['pass'] == "admin"){
       $_SESSION["LOGIN"] = true; 
       $_SESSION["USER_NAME"] = $_POST['user'] ;
       echo "login ok";
       //header("Location: bemvindo.html");
    }else{
         header('HTTP/1.0 403 Forbidden');
         die('Voce nao esta logado' . $_SESSION["LOGIN"]);  
    }
?>