<?php
require_once(__DIR__ .'/../cors.php');
include_once(__DIR__ .'/../controllers/User.php');

if(!isset($_SESSION)) 
{
    session_start();
}

$controller = new User();

$data = (array)json_decode(file_get_contents('php://input'));
$username = $data['username'];
$password = $data['password'];

// echo $username;

$isLoggedIn = $controller->login($username, $password);

if($isLoggedIn['status'] === true) 
{
    #http response
    http_response_code(200);
    echo json_encode($isLoggedIn);
}
else
{
    #http response
    http_response_code(500);
    echo json_encode($isLoggedIn);
}
?>