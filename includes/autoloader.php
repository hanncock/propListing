<?php

include 'classes/Mail/MailView.php';

include 'classes/Dbh.php';

spl_autoload_register('myAutoloader');

function myAutoLoader($className){

    $url = explode('api/',$_SERVER['REQUEST_URI']);

    $endpoints = explode('/',implode($url));
  
    $path = 'classes/';

    $extrafile = $clsName = ucfirst($endpoints[1]);;

    $extension = '.php';

    $fullpath = $path. $extrafile. "/" .$className. $extension;
    
    $chekPath = $path. $extrafile;

    if(is_dir($chekPath)){

        require_once $fullpath;

    }else{

        echo json_encode(['404 wrong api declaration']);
        exit();
        
    }

    




}
