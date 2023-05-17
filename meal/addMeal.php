<?php
    error_reporting(0);
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, X-Auth-Token, Origin, Authorization");

    include('functions.php');

    $method = $_SERVER["REQUEST_METHOD"];

    

    if ($method == 'POST'){
        $inputData = json_decode(file_get_contents("php://input"), true);
        
        if (empty($inputData)){
            $addMeal = addMealFunc($_POST);
        } else {
            $addMeal = addMealFunc($inputData);
        }
        echo $addMeal;

    } else {
        $data = [
            'status' => 405,
            'messeage' => $method. ' Method Not Allowed',
        ];
        header("HTTP/1.0 405 Method Not Allowed");
        echo json_encode($data);
    }

?>