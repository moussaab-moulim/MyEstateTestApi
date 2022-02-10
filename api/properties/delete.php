<?php
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include_once $_SERVER['DOCUMENT_ROOT'].'/MyEstateTestApi/config/database.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/MyEstateTestApi/controllers/properties.php';

$database = new Database();
$db = $database->getConnection();

$item = new Properties($db);
$data = json_decode(file_get_contents('php://input'));
$item->id = $data->id;

if($item->delete()):
    http_response_code(200);
    echo json_encode(
        array(
            "type"=>"success",
            "title"=>"Success",
            "message"=>"The Property was deleted successfully."
        )
    );
else:
    http_response_code(404);
    echo json_encode(
        array(
            "type"=>"danger",
            "title"=>"Failed",
            "message"=>"The Property was not deleted successfully. Please try again."
        )
    );
endif;