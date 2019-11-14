<?php


class User {
    
     private  $id;
     private  $email;
     private  $password;
     
     public function toString()
     {
       return "email:" . $this->email . 
       "<br> password:" . $this->$password;
     }            
     public function setEmail($email)
     {
       $this->email = $email;
     }            
      public function setPassword($password)
     {
       $this->password = $password;
     }  
}
