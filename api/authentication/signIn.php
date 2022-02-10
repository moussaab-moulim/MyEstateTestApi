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
    http_response_code(200);
    echo json_encode($user->signIn());
else :
    http_response_code(400);
    echo json_encode($user->signIn());
endif;
