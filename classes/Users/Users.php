<?php

class Users extends Dbh{


    protected function createUser($id,$fName,$sName,$idNo,$email,$pass,$phone,$gender,$activeUser){


        // $hashedpwd =y password_hash($pwd,PASSWORD_DEFAULT);
        if($id == null){
             $id = $id ?? $this->getId();

            $sql = "INSERT INTO users (id,fName,sName,idNo,email,password,phoneNum,gender,user)VALUES('$id','$fName','$sName',$idNo,'$email','$pass',$phone,'$gender','$activeUser')";

        }else{
            $sql = "UPDATE users set fName='$fName', sName='$sName', idNo='$idNo', email='$email', phoneNum='$phone', gender='$gender' WHERE id='$id'";
        }
        // $hashedpwd = password_hash($pwd,PASSWORD_DEFAULT);
        $stmt = $this->connect()->prepare($sql);

        if(!$stmt->execute()){
            $stmt = null;
            exit();
        }

        return 'User Creation Success';

        $subject = 'New Login Credentials';

        $sendCred = new MailView($fName,$subject,[$email,$pass]);
        // $data = $sendCred -> sendMail();

        return 'success';

        $stmt = null;

    }


    protected function checkMail(){
        
    }

    protected function fetchUsers(){
        
        $sql = "SELECT * FROM users ";
        
        $stmt = $this->connect()->prepare($sql);
        
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $results;
        
    }

    protected function fetchselectedUsers($id,$email){
        
        $sql = "SELECT * FROM users where id='$id' AND email='$email'";
        
        $stmt = $this->connect()->prepare($sql);
        
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $results;
        
    }


    protected function loginUser($name,$pass){

    // USER DETAILS
        // $sql = "SELECT * FROM users WHERE email='$name' AND password='$pass'";
        $sql = "SELECT * FROM users WHERE username='$name' AND password='$pass'";
        

        $stmt = $this->connect()->prepare($sql);
        
        $stmt->execute();


        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

//         $results = $stmt->rowCount();

        if(count($results) == 0){

            return [
            "success"=>false,
            "data"=>'Login failed Incorrect username or password',
            ];
            
        }else{

            $user_data = $results;

            $userId = $user_data[0]['id'];

            $sqlCompanies = "SELECT companyId FROM usercompanies WHERE userId='$userId' ";

             $stmt = $this->connect()->prepare($sqlCompanies);

             $stmt->execute();

             $user_companies_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

             $companyList = [];

             foreach( $user_companies_data as $companyId){
                array_push($companyList,$companyId['companyId']);
             }

             $allVal = implode(",", $companyList);


             $sqlCompanies_Data = "SELECT * FROM companies WHERE companyId IN ('$allVal') ";

             $stmt = $this->connect()->prepare($sqlCompanies_Data);

             $stmt->execute();

             $user_companies_details = $stmt->fetchAll(PDO::FETCH_ASSOC);

             $loginData = [
//                 'userDetails'=>$results,
                'userId'=>$results[0]['id'],
                'firstName'=>$results[0]['fName'],
                'otherNames'=>$results[0]['sName'],
                'idNo'=>$results[0]['idNo'],
                'email'=>$results[0]['email'],
                'phone'=>$results[0]['phoneNum'],
                'gender'=>$results[0]['gender'],
                'photo'=>$results[0]['gender'],
                'allowedCompanies'=> $user_companies_details
             ];

            return [
            "success"=>true,
            "data"=>$loginData
            ];

//            return $data;
        }
        // return $results;
    }


    // public function found(){
    //     echo 'found';
    // }
}

// $sql = "SELECT * FROM users where id= '$name'";