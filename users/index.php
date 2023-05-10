<?php
    error_reporting(E_ALL);
    ini_set('display_errors',1);
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");

    include 'DBConnect.php';

    $db = new DBConnect;
    $conn = $db -> connect();

    $method = $_SERVER['REQUEST_METHOD'];

    $user = json_decode( file_get_contents('php://input') );
    //$sql = "INSERT INTO react_php (text) VALUES ('test')";
    //$stmt = $conn->prepare($sql);
    
    if ($stmt->execute()){
        echo "Dziala";
    } else {
        echo "Popsute";
    }


    switch($method){
        case "POST":
            $user = json_decode( file_get_contents('php://input') );
            $sql = "INSERT INTO users (login, email, password) VALUES (:login, :email, :password)";
            $stmt = $conn->prepare($sql);
            $stmt -> bindParam(':name', $user->login);
            $stmt -> bindParam(':email', $user->email);
            $stmt -> bindParam(':password', $user->password);

            if ($stmt -> execute()){
                $response = ['status' => 1, 'message' => 'Udało się dodać nowego użytkownika do bazy danych'];
            } else {
                $response = ['status' => 0, 'message' => 'Nie udało się dodać nowego użytkownika do bazy danych'];
            }
            echo json_encode($response);
            break;
    }


?>