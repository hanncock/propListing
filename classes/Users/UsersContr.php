<?php

class UsersContr extends Users{

    private $id;
    private $fName;
    private $sName;
    private $idNo;
    private $email; 
    private $phone;
    private $gender;
    private $pass;
    private $user;

    
    public function __construct($values){
        $val = $values;
        $this -> id = $val['id'] ?? null;
        $this -> fName = $val['fname'] ?? null;
        $this -> sName = $val['sname'] ?? null;
        $this -> idNo = $val['idNo'] ?? 0;
        $this -> email = $val['email'] ?? null;
        $this -> pass = $val['pass'] ?? null;
        $this -> phone = $val['phoneNum'] ?? 0;
        $this -> gender = $val['gender'] ?? null;
        $this -> user = $val['user'] ?? null;

    }

    public function dispUser(){

        return $this->fName;

    }
    
    public function addUser(){

        $res = $this->createUser($this->id,$this->fName,$this->sName,$this->idNo,$this->email,$this->pass,$this->phone,$this->gender,$this->user);

        return $res;
    }

    public function login(){

        $res = $this->LoginUser($this->email, $this->pass);

        return $res;
    }

    
}

// INSERT INTO properties(propName,propType,propDescription,propContact,propPrice,propSize,propLeaseType,propMonthlyPay,propStatus,propUnits,propAvailableUnits,propBeds,propBaths,propSqrfoot,image) VALUES ('','','',,,'','',,'',,,,,,'/home/hanno/Desktop/logo/property listing/db/classes/Properties/propImages/img_3b80eb8.png')