<?php
class Dbh{
    // private $host = 'localhost';
    // private $username = 'soke';
    // private $password ='';
    // private $dbname = 'ekso';

    protected function connect(){

        try{
            $username = 'soke';
            $password = '';
            $dbh = new PDO('mysql:host=localhost;dbname=hously',$username,$password);
            return $dbh;

        }catch(PDOException $e){
            print "Error!:".$e->getMessage()."<br/>";
            die();
        }
    }

    protected function getId(){
        $id = strtotime(date("Y-m-d H:i:s.u"));
        return $id;
        // $sql = "SELECT id FROM keyfinder WHERE id=(SELECT max(id) FROM keyfinder)";

        // $stmt = $this->connect()->prepare($sql);
        
        // $stmt->execute();
        // $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // return $results;
    }

    protected function updateId($newId){
        // $sql = "UPDATE set id = "";

    }

}