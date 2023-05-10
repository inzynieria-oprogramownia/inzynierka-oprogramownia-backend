<?php
    error_reporting(E_ALL);
    ini_set('display_errors',1);
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");

    include 'DBConnect.php';

    $db = new DBConnect;
    $conn = $db -> connect();

    $method = $_SERVER['REQUEST_METHOD'];

    $meal = json_decode( file_get_contents('php://input') );
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
            $sql = "INSERT INTO meals (name, ing, kcal) VALUES (:name, :ing, :kcal)";
            $stmt = $conn->prepare($sql);
            $stmt -> bindParam(':name', $meal->name);
            $stmt -> bindParam(':email', $meal->ing);
            $stmt -> bindParam(':password', $meal->kcal);

            if ($stmt -> execute()){
                $response = ['status' => 1, 'message' => 'Udało się dodać posiłek do bazy danych'];
            } else {
                $response = ['status' => 0, 'message' => 'Nie udało się dodać posiłku do bazy danych'];
            }
            echo json_encode($response);
            break;
    }


?>