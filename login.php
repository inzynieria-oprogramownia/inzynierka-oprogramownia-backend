<?php
    session_start();
    
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
            $user = json_decode(file_get_contents('php://input'));
            $sql = "SELECT login, password FROM users WHERE login = :login AND password = :password";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':login', $user->login);
            $stmt->bindParam(':password', $user->password);
    
            if ($stmt->execute()){
                if ($stmt->rowCount() > 0) {
                    $_SESSION['logged_in'] = true;
                    $_SESSION['login'] = $user->login;
                
                    $response = ['status' => 1, 'message' => 'Udało się zalogować użytkownika'];
                } else {
                    $response = ['status' => 0, 'message' => 'Nie znaleziono użytkownika o podanych danych logowania'];
                }
            } else {
                $response = ['status' => 0, 'message' => 'Błąd zapytania do bazy danych'];
            }
            echo json_encode($response);
            break;
    }
    


?>