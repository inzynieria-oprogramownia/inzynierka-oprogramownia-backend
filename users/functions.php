<?PHP

require '..\DBconnect.php';

function getAllUsers()
{
    global $conn;

    $query = "SELECT * FROM react_php_users";
    $result = mysqli_query($conn, $query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {

            $res = mysqli_fetch_all($result, MYSQLI_ASSOC);

            $data = [
                'status' => 200,
                'message' => 'Customer List Fetched Successfully',
                'data' => $res
            ];
            header("HTTP/1.0 200 Customer List Fetched Successfully");
            return json_encode($data);

        } else {
            $data = [
                'status' => 404,
                'messeage' => 'No Customer Found',
            ];
            header("HTTP/1.0 404 No Customer Found");
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

function error422($mess)
{
    $data = [
        'status' => 422,
        'messeage' => $mess,
    ];
    header("HTTP/1.0 500 Unprocessable Entity");
    echo json_encode($data);
    exit();
}

function addUserFunc($addUser)
{
    global $conn;

    $login = mysqli_real_escape_string($conn, $addUser['login']);
    $email = mysqli_real_escape_string($conn, $addUser['email']);
    $password = mysqli_real_escape_string($conn, $addUser['password']);

    if (empty(trim($login))) {

        return error422('Enter your login');

    } elseif (empty(trim($email))) {

        return error422('Enter your email');

    } elseif (empty(trim($password))) {

        return error422('Enter your password');

    } else {
        $query = "INSERT INTO react_php_users (email, login, password) VALUES ('$email', '$login', '$password')";
        $result = mysqli_query($conn, $query);

        if ($result) {

            $data = [
                'status' => 201,
                'message' => 'User Created Successfully',
            ];
            header("HTTP/1.0 201 Created");
            return json_encode($data);

        } else {
            $data = [
                'status' => 500,
                'messeage' => 'Internal Server Error',
            ];
            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        }
    }

}


function getUserFunc($userID)
{
    global $conn;

    if ($userID['id'] == null) {
        return error422('Enter your user ID');
    }

    $ID = mysqli_real_escape_string($conn, $userID['id']);

    $query = "SELECT u.*, lr.mealID AS liked_meal_id, rec.id AS created_meal_id, w.weight AS user_weight, w.date AS user_weight_date
    FROM react_php_users AS u
    LEFT JOIN react_php_liked_recipe AS lr ON u.id = lr.userID
    LEFT JOIN react_php_recipe AS r ON lr.mealID = r.id
    LEFT JOIN react_php_recipe AS rec ON u.id = rec.userID
    LEFT JOIN react_php_user_weight AS w ON w.userid = u.id
    WHERE u.id='$ID'
    GROUP BY u.id, lr.mealID, rec.id, w.weight, w.date;";

    $result = mysqli_query($conn, $query);

    if ($result) {

        if (mysqli_num_rows($result) > 0) {

            $data = [
                'status' => 200,
                'message' => 'User Found',
                'data' => [
                    'liked_meals' => [],
                    'created_meals' => [],
                    'user_weights' => [],
                ],
            ];

            while ($row = mysqli_fetch_object($result)) {
                if (!isset($data['data']['id'])) {
                    $data['data']['id'] = $row->id;
                    $data['data']['login'] = $row->login;
                    $data['data']['email'] = $row->email;
                    $data['data']['password'] = $row->password;
                }

                if ($row->liked_meal_id != null) {
                    $liked_meal = new stdClass();
                    $liked_meal->id = $row->liked_meal_id;
                    if (!in_array($liked_meal, $data['data']['liked_meals'])) {
                        $data['data']['liked_meals'][] = $liked_meal;
                    }
                }

                if ($row->created_meal_id != null) {
                    $created_meal = new stdClass();
                    $created_meal->id = $row->created_meal_id;
                    if (!in_array($created_meal, $data['data']['created_meals'])) {
                        $data['data']['created_meals'][] = $created_meal;
                    }
                }

                if ($row->user_weight != null) {
                    $user_weight = new stdClass();
                    $user_weight->weight = $row->user_weight;
                    $user_weight->date = $row->user_weight_date;
                    if (!in_array($user_weight, $data['data']['user_weights'])) {
                        $data['data']['user_weights'][] = $user_weight;
                    }
                }
            }
            header("HTTP/1.0 200 Success");
            return json_encode($data);

        } else {
            $data = [
                'status' => 404,
                'message' => 'No User Found',
            ];
            header("HTTP/1.0 404 Not Found");
            return json_encode($data);
        }

    } else {
        $data = [
            'status' => 500,
            'message' => 'Internal Server Error',
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
    }
}


function loginUserFunc($loginUser)
{

    global $conn;

    if ($loginUser['login'] == null) {

        return error422('Enter your login');

    } elseif ($loginUser['password'] == null) {

        return error422('Enter your password');

    }

    $login = mysqli_real_escape_string($conn, $loginUser['login']);
    $password = mysqli_real_escape_string($conn, $loginUser['password']);


    $query = "SELECT id FROM react_php_users WHERE login='$login' AND password='$password' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result) {

        if (mysqli_num_rows($result) == 1) {

            $res = mysqli_fetch_assoc($result);
            $data = [
                'status' => 200,
                'messeage' => 'Ok',
                'data' => $res
            ];
            header("HTTP/1.0 500 Not Found");
            return json_encode($data);

        } else {
            $data = [
                'status' => 404,
                'messeage' => 'No User Found',
            ];
            header("HTTP/1.0 500 Not Found");
            return json_encode($data);
        }

    } else {
        $data = [
            'status' => 500,
            'messeage' => 'Internal Server Error',
        ];
        header("HTTP/1.0 500 Not Found");
        return json_encode($data);
    }

}

function addLikedMealFunc($addLikedMeal)
{
    global $conn;

    $userID = mysqli_real_escape_string($conn, $addLikedMeal['userID']);
    $mealID = mysqli_real_escape_string($conn, $addLikedMeal['mealID']);

    if (empty(trim($userID))) {

        return error422('Enter userID');

    } elseif (empty(trim($mealID))) {

        return error422('Enter mealID');

    } else {
        $query = "INSERT INTO react_php_liked_recipe (userID, mealID) VALUES ('$userID', '$mealID')";
        $result = mysqli_query($conn, $query);

        if ($result) {

            $data = [
                'status' => 201,
                'message' => 'Meal Liked Successfully',
            ];
            header("HTTP/1.0 201 Created");
            return json_encode($data);

        } else {
            $data = [
                'status' => 500,
                'messeage' => 'Internal Server Error',
            ];
            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        }
    }

}

function getLikedMealsFunc($userid)
{
    global $conn;

    if ($userid['userid'] == null) {
        return error422('Enter your user ID');
    }

    $ID = mysqli_real_escape_string($conn, $userid['userid']);

    $query = "SELECT rec.id, rec.image, rec.title, rec.date, rec.description, rec.time, rec.people, rec.kcal, rec.mealoption, ing.name, ing.weight
    FROM react_php_liked_recipe AS lr
    JOIN react_php_recipe AS rec ON rec.id = lr.mealID 
    JOIN react_php_ingredient AS ing ON ing.mealid = rec.id
    WHERE lr.userID='$ID';";

    $result = mysqli_query($conn, $query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $data = [
                'status' => 200,
                'message' => 'Liked Meals Found',
                'data' => [
                    'meals' => [],
                ],
            ];

            $meals = [];

            while ($row = mysqli_fetch_object($result)) {
                $mealId = $row->id;

                if (!isset($meals[$mealId])) {
                    $meals[$mealId] = [
                        'id' => $row->id,
                        'title' => $row->title,
                        'image' => $row->image,
                        'date' => $row->date,
                        'description' => $row->description,
                        'time' => $row->time,
                        'people' => $row->people,
                        'kcal' => $row->kcal,
                        'mealoption' => $row->mealoption,
                        'ingredients' => [],
                    ];
                }

                $ingredient = new stdClass();
                $ingredient->name = $row->name;
                $ingredient->weight = $row->weight;
                if (!in_array($ingredient, $meals[$mealId]['ingredients'])) {
                    $meals[$mealId]['ingredients'][] = $ingredient;
                }
            }

            $data['data']['meals'] = array_values($meals);

            header("HTTP/1.0 200 Success");
            return json_encode($data);
        } else {
            $data = [
                'status' => 404,
                'message' => 'No Liked Meals Found',
            ];
            header("HTTP/1.0 404 Not Found");
            return json_encode($data);
        }
    } else {
        $data = [
            'status' => 500,
            'message' => 'Internal Server Error',
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
    }
}



function getCreatedMealsFunc($userid)
{
    global $conn;

    if ($userid['userid'] == null) {
        return error422('Enter your user ID');
    }

    $ID = mysqli_real_escape_string($conn, $userid['userid']);

    $query = "SELECT rec.id, rec.image, rec.title, rec.date, rec.description, rec.time, rec.people, rec.kcal, rec.mealoption, ing.name, ing.weight
    FROM react_php_recipe AS rec
    LEFT JOIN react_php_ingredient AS ing ON ing.mealid = rec.id
    WHERE rec.userID='$ID'
    ORDER BY rec.id;";

    $result = mysqli_query($conn, $query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $data = [
                'status' => 200,
                'message' => 'Created Meals Found',
                'data' => [
                    'meals' => [],
                ],
            ];

            $meals = [];

            while ($row = mysqli_fetch_object($result)) {
                $id = $row->id;

                if (!isset($meals[$id])) {
                    $meals[$id] = [
                        'id' => $id,
                        'title' => $row->title,
                        'image' => $row->image,
                        'date' => $row->date,
                        'description' => $row->description,
                        'time' => $row->time,
                        'people' => $row->people,
                        'kcal' => $row->kcal,
                        'mealoption' => $row->mealoption,
                        'ingredients' => [],
                    ];
                }

                if (!empty($row->name) && !empty($row->weight)) {
                    $ingredient = new stdClass();
                    $ingredient->name = $row->name;
                    $ingredient->weight = $row->weight;
                    $meals[$id]['ingredients'][] = $ingredient;
                }
            }

            $data['data']['meals'] = array_values($meals);

            header("HTTP/1.0 200 Success");
            return json_encode($data);
        } else {
            $data = [
                'status' => 404,
                'message' => 'No Created Meals Found',
            ];
            header("HTTP/1.0 404 Not Found");
            return json_encode($data);
        }
    } else {
        $data = [
            'status' => 500,
            'message' => 'Internal Server Error',
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
    }
}


?>