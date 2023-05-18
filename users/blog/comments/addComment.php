<?php
    error_reporting(0);
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
    header("Access-Control-Max-Age: 86400"); // Dopuszczalny czas buforowania nagłówków CORS
    
    // Obsługa żądań OPTIONS (preflight)
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        http_response_code(200);
        exit();
    }

    include('functions.php');

    $method = $_SERVER["REQUEST_METHOD"];

    

    if ($method == 'POST'){
        $inputData = json_decode(file_get_contents("php://input"), true);
        
        if (empty($inputData)){
            $addComment = addCommentFunc($_POST);
        } else {
            $addComment = addCommentFunc($inputData);
        }
        echo $addComment;

    } else {
        $data = [
            'status' => 405,
            'messeage' => $method. ' Method Not Allowed',
        ];
        header("HTTP/1.0 405 Method Not Allowed");
        echo json_encode($data);
    }

?>