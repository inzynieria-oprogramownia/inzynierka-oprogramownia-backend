<?php
    session_start();
    
    error_reporting(E_ALL);
    ini_set('display_errors',1);
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");

    include('getUsers.php');

    $method = $_SERVER['REQUEST_METHOD'];

    

    if ($method == "GET"){
        $customerList = getCustomerList();
        echo $customerList;

    } else {
        $data = [
            'status' => 405,
            'messeage' => $method. 'Method Not Allowed',
        ];
        header("HTTP/1.0 405 Method Not Allowed");
        echo json_encode($data);
    }

?>