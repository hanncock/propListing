<?php

header("Access-Control-Allow-Origin: *");
// header('Access-Control-Allow-Methods: GET, POST');
// header("Access-Control-Allow-Headers: X-Requested-With");
header("Access-Control-Allow-Origin: *");
header("Content-type: application/json; charset=UTF-8");
include 'includes/autoloader.php';


if(strpos($_SERVER['REQUEST_URI'],'api') == false){

//     echo $_SERVER['REQUEST_URI'];
   echo 'wrong api start format';
    exit();
}

$url_first = explode('api/',$_SERVER['REQUEST_URI']);

$query_param = explode('?',$url_first[1]);

$endpoint = $query_param[0] ?? null;

$query_params = $query_param[1] ?? null;

$requestMethod = $_SERVER['REQUEST_METHOD'];

$getClassendpoints = explode('/',$url_first[1]);

$clsName = ucfirst($getClassendpoints[0]);

if($_SERVER['REQUEST_METHOD'] == 'GET'){


    $classInUse = $clsName."View";


     switch($endpoint){

            case 'users/list':
                $res =  new $classInUse();

                if(empty($query_params)){
                    $data =  $res ->getUsers();
                    echo json_encode($data);
                }else{
                    $name = $_GET['name'] ?? null;
                    $email = $_GET['email'] ?? null;
                    $id = $_GET['id'] ?? null;
                    $data =  $res ->getSelectUser($id);
                    // print_r($endpoint);
                    echo json_encode($data);
                }

                break;

            case 'properties/list':
                $query_params = $_SERVER['QUERY_STRING'] ?? null;

                // echo json_encode($query_param);
                $data = new $classInUse();
                if($query_param == null){

                    echo json_encode('null values');

                    // $resu = $data->getProperties(null);
                    // echo json_encode([
                    //     // "count"=>count($resu),
                    //     "data"=>$resu
                    // ]);
                }else{
                    // echo $query_param[1];
                    $resu = $data->getProperties($query_param[1]);
                    echo json_encode([
                        // "count"=>count($resu),
                        "data"=>$resu
                    ]);
                }
                
                break;

            // case 'properties/id?':
            //     echo json_encode('fetching new propValues');
            //     // $data = new $classInUse();
            //     // $resu = $data->getProperties();
            //     // echo json_encode([
            //     //     // "count"=>count($resu),
            //     //     "data"=>$resu
            //     // ]);
            //     break;


            default:
                echo json_encode('nothing found');
                break;
        }

}

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $classInUse = $clsName."Contr";
// echo json_encode($endpoint);
// break;
// return $classInUse;
    $post = json_decode(file_get_contents('php://input'),true);

    // print_r($endpoint);
    // print_r($classInUse);

        switch($endpoint){

            case 'users/add':
                $data = new $classInUse($post);
                $resu = $data->addUser();
                echo json_encode([
                    // "count"=>count($resu),
                    "data"=>$resu]);

                break;

                case 'users/login':

                    // echo json_encode('login');

                    $data = new $classInUse($post);
                    $resu = $data->login();
                    echo json_encode($resu);
                    break;

                case 'students/add':
                    $data = new $classInUse($post);
                    $resu = $data->addStudent();
                    echo json_encode([
                        // "count"=>count($resu),
                        "data"=>$resu
                    ]);
                    break;

                case 'properties/add':
            
                    $data = new $classInUse($post);

                    // print_r($data);
                    $resu = $data->addProperty();
                    echo json_encode([
                        // "count"=>count($resu),
                        "data"=>$resu
                    ]);
                    break;

                case 'properties/del':
                    $query_params = $_SERVER['QUERY_STRING'] ?? null;

                    // $data = new $classInUse();

        
                    $data = new $classInUse($query_params);

                    // print_r($data);
                    $resu = $data->delProperty($query_params);
                    echo json_encode([
                        // "count"=>count($resu),
                        "data"=>$resu
                    ]);
                break;

                   
               
            default:
//                 echo json_encode('nothing found');
                break;

        }

}













