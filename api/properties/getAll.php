<?php
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json; charset=UTF-8");

include_once $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/properties.php';

$database = new Database();
$db = $database->getConnection();

$items = new Properties($db);

//$stmt = $items->getAll($_POST['authorization']);
$stmt = $items->getAll();
if ($stmt) :
    $itemCount = $stmt->rowCount();
    $stmt->rowCount();
    if ($itemCount > 0) :
        header('HTTP/1.0 200 OK');
        $arr = array();
        $arr['response'] = array();
        $arr['count'] = $itemCount;

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) :
            $e = $row;
            array_push($arr['response'], $e);
        endwhile;
        echo json_encode($arr);
    else :
        http_response_code(404);
        echo json_encode(
            array(
                "type" => "danger",
                "title" => "Failed",
                "message" => "No records found."
            )
        );
    endif;
else :
    http_response_code(404);
    echo json_encode(
        array(
            "type" => "danger",
            "title" => "Failed",
            "message" => "Your token did not match the expected token. Please contact an administrator."
        )
    );
endif;
