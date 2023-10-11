<?php

// include "../autoLoader/autoloader.php";

class UsersView extends Users{

    // // public $method;
    // public $values;

    // public function __construct($values){
    
    //     // $this -> method = $method;
    //     $this -> values = $values;
    // }

    

    public function getUsers(){
        
        return $this->fetchUsers();
    }

    public function getSelectUser($name){

        return $this->fetchselectedUsers($name);

    }

   
}