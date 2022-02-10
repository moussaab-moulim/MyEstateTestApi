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
$item->title = $data->title;
$item->description = $data->description;
$item->features = $data->features;
$item->images = $data->images;
$item->adresse = $data->adresse;
$item->price = $data->price;
$item->type = $data->type;
$item->size = $data->size;

if($item->update()):
    http_response_code(200);
    echo json_encode(
        array(
            "type"=>"success",
            "title"=>"Success",
            "message"=>"The property was updated successfully."
        )
    );
else:
    http_response_code(404);
    echo json_encode(
        array(
            "type"=>"danger",
            "title"=>"Failed",
            "message"=>"The property was not updated successfully. Please try again."
        )
    );
endif;