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

    $userID = mysqli_real_escape_string($conn, $addMeal['userID']);
    $title = mysqli_real_escape_string($conn, $addMeal['title']);
    $date = date('Y.m.d');
    $description = mysqli_real_escape_string($conn, $addMeal['description']);
    $time = mysqli_real_escape_string($conn, $addMeal['time']);
    $people = mysqli_real_escape_string($conn, $addMeal['people']);
    $kcal = mysqli_real_escape_string($conn, $addMeal['kcal']);
    $mealoption = mysqli_real_escape_string($conn, $addMeal['mealoption']);

    if (empty(trim($userID))) {
        return error422('Enter userID');
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
        $targetDirectory = 'meal_images/'.$userID.'/';
        $targetFile = $targetDirectory . basename($_FILES["uploadfile"]["name"]);

        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $allowedExtensions = array('jpg', 'jpeg', 'png');
        
        if (!in_array($imageFileType, $allowedExtensions)) {
            return error422('Invalid image file type');
        }

        if (move_uploaded_file($_FILES["uploadfile"]["tmp_name"], $targetFile)) {
            $query = "INSERT INTO react_php_recipe (userID, image, title, date, description, time, people, kcal, mealoption) VALUES ('$userID', '$targetFile', '$title', '$date', '$description', '$time', '$people', '$kcal', '$mealoption')";
            $result = mysqli_query($conn, $query);

            if ($result) {
                $mealId = mysqli_insert_id($conn);

                if (isset($addMeal['ingredient']) && is_array($addMeal['ingredient'])) {
                    $ingredients = $addMeal['ingredient'];

                    foreach ($ingredients as $ingredient) {
                        $ingredientName = mysqli_real_escape_string($conn, $ingredient['name']);
                        $ingredientWeight = mysqli_real_escape_string($conn, $ingredient['weight']);
                        $ingredientQuery = "INSERT INTO react_php_ingredient (mealid, name, weight) VALUES ('$mealId', '$ingredientName', '$ingredientWeight')";
                        $ingredientResult = mysqli_query($conn, $ingredientQuery);

                        if(!$ingredientResult) {
                            $data = [
                                'status' => 500,
                                'message' => 'Internal Server Error',
                            ];
                            header("HTTP/1.0 500 Internal Server Error");
                            return json_encode($data);
                        }
                    }
                }

                $data = [
                    'status' => 201,
                    'message' => 'Meal Added Successfully',
                ];
                header("HTTP/1.0 201 Created"); 
                return json_encode($data);

            } else {
                $data = [
                    'status' => 500,
                    'message' => 'Internal Server Error',
                ];
                header("HTTP/1.0 500 Internal Server Error");
                return json_encode($data);
            }
        } else {
            $data = [
                'status' => 500,
                'message' => 'Failed to upload image',
            ];
            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        }
    }
}

 
function getMealFunc($mealID){
 
    global $conn;
 
    if ($mealID['id'] == null){
 
        return error422('Enter meal ID');
 
    } 
 
    $ID = mysqli_real_escape_string($conn, $mealID['id']);
 
    $query = "SELECT r.backgroundImage, r.title, r.date, r.description, r.time, r.people, r.kcal, r.mealoption, ing.name AS ingredient_name, ing.weight AS ingredient_weight
          FROM react_php_recipe as r
          JOIN react_php_ingredient as ing ON r.id = ing.mealid
          WHERE r.id = '$ID'";
 
 
    $result = mysqli_query($conn,$query);
 
    if ($result){
 
        if (mysqli_num_rows($result) > 0) {
 
            $data = [
                'status' => 200,
                'messeage' => 'Meal Found',
                'data' => [
                    'ingredients' => [],
                ]
            ];
 
            while ($row = mysqli_fetch_object($result)) {
                if (!isset($data['data']['title'])) {
                    $data['data']['title'] = $row->title;
                    $data['data']['backgroundImage'] = $row->backgroundImage;
                    $data['data']['date'] = $row->date;
                    $data['data']['description'] = $row->description;
                    $data['data']['time'] = $row->time;
                    $data['data']['people'] = $row->people;
                    $data['data']['kcal'] = $row->kcal;
                    $data['data']['mealoption'] = $row->mealoption;
                }
 
                $ingredient = new stdClass();
                $ingredient->name = $row->ingredient_name;
                $ingredient->weight = $row->ingredient_weight;
                if (!in_array($ingredient, $data['data']['ingredients'])) {
                    $data['data']['ingredients'][] = $ingredient;
                }
            }
 
 
 
 
            header("HTTP/1.0 200 Success");
            return json_encode($data);
 
        } else {
            $data = [
                'status' => 404,
                'messeage' => 'No Meal Found',
            ];
            header("HTTP/1.0 500 Not Found");
            return json_encode($data);
        }
 
    } else {
        $data = [
            'status' => 500,
            'messeage' => 'Internal Server Error',
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
    }
 
}
 
 
function getAllMealsFunc(){
    global $conn;
 
    $query = "SELECT backgroundImage, title, date, description, time, people, kcal, mealoption FROM react_php_recipe";
    $result = mysqli_query($conn, $query);
 
    if ($result){
        if (mysqli_num_rows($result) > 0){
 
            $res = mysqli_fetch_all($result,MYSQLI_ASSOC);
 
            $data = [
                'status' => 200,
                'message' => 'Meal List Fetched Successfully',
                'data' => $res
            ];
            header("HTTP/1.0 200 Meal List Fetched Successfully");
            return json_encode($data);
 
        } else {
            $data = [
                'status' => 404,
                'messeage' => 'No Meal Found',
            ];
            header("HTTP/1.0 404 No Meal Found");
            return json_encode($data);
        }
 
 
    } else {
        $data = [
            'status' => 500,
            'messeage' => 'Internal Server Error',
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
    }
}
 
?>