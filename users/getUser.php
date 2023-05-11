<?php 
    error_reporting(0);
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");
    header("Access-Control-Allow-Method: POST");
    header("Access-Control-Allow-Headers: *");

    include('functions.php');

    $method = $_SERVER["REQUEST_METHOD"];

    if ($method == "GET") {
        $getUser = getUserFunc($_GET);
        echo $getUser;

    } else {
        $data = [
            'status' => 405,
            'messeage' => $method. ' Method Not Allowed',
        ];
        header("HTTP/1.0 405 Method Not Allowed");
        echo json_encode($data);
    }



?>