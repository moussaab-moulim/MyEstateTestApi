<?php
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json; charset=UTF-8");

include_once $_SERVER['DOCUMENT_ROOT'] . '/MyEstateTestApi/config/database.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/MyEstateTestApi/controllers/authentication.php';

$database = new Database();
$db = $database->getConnection();

$token = new Authentication($db);

if ($token->auth()) :
    http_response_code(200);
    echo json_encode(
        $token->auth()
    );
else :
    http_response_code(404);
    echo json_encode(
        array(
            "type" => "danger",
            "title" => "Failed",
            "message" => "Could not create the token for this API. Please contact your administrator."
        )
    );
endif;
