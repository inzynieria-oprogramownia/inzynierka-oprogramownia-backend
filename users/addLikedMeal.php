<?php
    error_reporting(0);
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");
    header("Access-Control-Allow-Method: POST");
    header("Access-Control-Allow-Headers: *");

    include('functions.php');

    $method = $_SERVER["REQUEST_METHOD"];

    

    if ($method == 'POST'){
        $inputData = json_decode(file_get_contents("php://input"), true);
        
        if (empty($inputData)){
            $addLikedMeal = addLikedMealFunc($_POST);
        } else {
            $addLikedMeal = addLikedMealFunc($inputData);
        }
        echo $addLikedMeal;

    } else {
        $data = [
            'status' => 405,
            'messeage' => $method. ' Method Not Allowed',
        ];
        header("HTTP/1.0 405 Method Not Allowed");
        echo json_encode($data);
    }

?>