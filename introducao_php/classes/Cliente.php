<?php 

   class Cliente
   {
       public  $nome;
       public  $sobrenome;
       public function toString()
       {
         return "Nome:" . $this->nome . 
         "<br> Sobrenome:" . $this->sobrenome;
       }
   }
?>
