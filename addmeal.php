<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

include 'DBConnect.php';

$db = new DBConnect;
$conn = $db->connect();
$method = $_SERVER['REQUEST_METHOD'];


$background = $_POST['background'];
$title = $_POST['title'];
$description = $_POST['description'];
$time = $_POST['time'];
$people = $_POST['people'];
$option = $_POST['option'];
$kcal = $_POST['kcal'];
$ingredients = $_POST['ingredients'];

echo $kcal;

$sql = "INSERT INTO meals (background, title, date, description, time, people, option, kcal, ingredients) 
    VALUES ($background, $title, date('d.m.Y'), $description, $time, $people, $option, $kcal, $ingredients)";

$stmt = $conn->prepare($sql);

if ($stmt->execute()) {
    $response = ['status' => 1, 'message' => 'Udało się dodać posiłek do bazy danych'];
} else {
    $response = ['status' => 0, 'message' => 'Nie udało się dodać posiłku do bazy danych'];
}
echo json_encode($response);



    switch($method){
        case "POST":
           /* $meal = json_decode( file_get_contents('php://input') );
            $sql = "INSERT INTO meals (background, title, date, description, time, people, option, kcal, ingredients) VALUES (:background, :title, :date, :description, :time, :people, :option, :kcal, :ingredients)";
            $stmt = $conn->prepare($sql);
            $stmt -> bindParam(':background', $meal->background);
            $stmt -> bindParam(':title', $meal->title);
            $stmt -> bindParam(':date', date("d.m.Y"));
            $stmt -> bindParam(':description', $meal->description);
            $stmt -> bindParam(':time', $meal->time);
            $stmt -> bindParam(':people', $meal->people);
            $stmt -> bindParam(':option', $meal->option);
            $stmt -> bindParam(':kcal', $meal->kcal);
            $stmt -> bindParam(':ingredients', $meal->ingredients);

            if ($stmt -> execute()){
                $response = ['status' => 1, 'message' => 'Udało się dodać posiłek do bazy danych'];
            } else {
                $response = ['status' => 0, 'message' => 'Nie udało się dodać posiłku do bazy danych'];
            }
            echo json_encode($response);*/
            break;
    }


?>