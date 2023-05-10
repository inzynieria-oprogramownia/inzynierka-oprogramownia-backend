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

    $meal = json_decode( file_get_contents('php://input') );

    switch($method){
        case "POST":
            // sprawdzanie, czy użytkownik jest zalogowany
            if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true){
                $response = ['status' => 0, 'message' => 'Użytkownik nie jest zalogowany'];
                echo json_encode($response);
                exit;
            }

            // aktualizacja ilości kalorii dla zalogowanego użytkownika
            $login = $_SESSION['login'];
            $sql = "UPDATE users SET maxkcal=:kcal WHERE login=:login";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':kcal', $meal->kcal);
            $stmt->bindParam(':login', $login);

            if ($stmt->execute()){
                $response = ['status' => 1, 'message' => 'Udało się zaktualizować ilość kalorii'];
            } else {
                $response = ['status' => 0, 'message' => 'Nie udało się zaktualizować ilości kalorii'];
            }
            echo json_encode($response);
            break;
    }
?>
