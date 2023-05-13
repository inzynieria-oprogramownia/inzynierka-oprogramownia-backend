<?php
    error_reporting(E_ALL);
    ini_set('display_errors',1);
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");
    header("Access-Control-Allow-Method: GET");
    header("Access-Control-Allow-Headers: *");

    include('functions.php');

    $method = $_SERVER['REQUEST_METHOD'];

    

    if ($method == "GET"){
        $getAllUsers = getAllUsers();
        echo $getAllUsers;

    } else {
        $data = [
            'status' => 405,
            'messeage' => $method. ' Method Not Allowed',
        ];
        header("HTTP/1.0 405 Method Not Allowed");
        echo json_encode($data);
    }

?>