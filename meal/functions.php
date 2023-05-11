<?PHP

require '..\DBconnect.php';

function error422($mess){
    $data = [
        'status' => 422,
        'messeage' => $mess,
    ];
    header("HTTP/1.0 500 Unprocessable Entity");
    echo json_encode($data);
    exit();
}

function addMealFunc($addMeal){
    
    global $conn;

    $backgroundImage = mysqli_real_escape_string($conn, $addMeal['backgroundImage']);
    $title = mysqli_real_escape_string($conn, $addMeal['title']);
    $date = date('Y.m.d');
    $description = mysqli_real_escape_string($conn, $addMeal['description']);
    $time = mysqli_real_escape_string($conn, $addMeal['time']);
    $people = mysqli_real_escape_string($conn, $addMeal['people']);
    $kcal = mysqli_real_escape_string($conn, $addMeal['kcal']);
    $mealoption = mysqli_real_escape_string($conn, $addMeal['mealoption']);

    if (empty(trim($backgroundImage))) {

        return error422('Enter meal backgroundImage');

    } elseif (empty(trim($title))) {

        return error422('Enter meal name');

    } elseif (empty(trim($description))) {

        return error422('Enter meal description');

    } elseif (empty(trim($time))) {

        return error422('Enter preparation time');

    } elseif (empty(trim($people))) {

        return error422('Enter for how many people this meal is');

    } elseif (empty(trim($kcal))) {

        return error422('Enter meal kcal');

    } elseif (empty(trim($mealoption))) {

        return error422('Enter meal type');

    } else {
        $query = "INSERT INTO react_php_recipe (backgroundImage, title, date, description, time, people, kcal, mealoption) VALUES ('$backgroundImage', '$title', '$date', '$description', '$time', '$people', '$kcal', '$mealoption')";
        $result = mysqli_query($conn, $query);

        if ($result){
            
            $data = [
                'status' => 201,
                'message' => 'Meal Added Successfully',
            ];
            header("HTTP/1.0 201 Created");
            return json_encode($data);

        } else {
            $data = [
                'status' => 500,
                'messeage' => $method. 'Internal Server Error',
            ];
            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        }
    }

}


?>