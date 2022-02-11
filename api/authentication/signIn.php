<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/authentication.php';

header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


$databaseService = new Database();
$db = $databaseService->getConnection();

$user = new Authentication($db);
$data = json_decode(file_get_contents("php://input"));

$user->password = $data->password;
$user->username = $data->username;

$signin = $user->signIn();
if (strpos($signin["message"], 'Successful')) :
    header('HTTP/1.0 200 OK');
    echo json_encode($signin);
else :
    header("HTTP/1.0 400 Bad Request");
    echo json_encode($signin);
endif;
