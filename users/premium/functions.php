<?PHP

require '..\..\DBconnect.php';

function error422($mess){
    $data = [
        'status' => 422,
        'messeage' => $mess,
    ];
    header("HTTP/1.0 500 Unprocessable Entity");
    echo json_encode($data);
    exit();
}

function updatePremiumFunc($input, $params){
    global $conn;

    if (!isset($params['id'])){
        return error422('User id not found in a link');
    } elseif (empty($params['id'])) {
        return error422('Enter id');
    }

    $ID = mysqli_real_escape_string($conn, $params['id']);

    $query = "UPDATE react_php_users SET premium = 1 WHERE id='$ID';";
    $result = mysqli_query($conn, $query);

    if ($result){
        $data = [
            'status' => 200,
            'message' => 'Premium Bought Successfully',
        ];
        header("HTTP/1.0 200 Premium Bought Successfully");
        return json_encode($data);
    } else {
        $data = [
            'status' => 500,
            'message' => 'Internal Server Error',
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
    }
}


function removePremiumFunc($input, $params){
    global $conn;

    if (!isset($params['id'])){
        return error422('User id not found in a link');
    } elseif (empty($params['id'])) {
        return error422('Enter id');
    }

    $ID = mysqli_real_escape_string($conn, $params['id']);

    $query = "UPDATE react_php_users SET premium = 0 WHERE id='$ID';";
    $result = mysqli_query($conn, $query);

    if ($result){
        $data = [
            'status' => 200,
            'message' => 'Premium Removed Successfully',
        ];
        header("HTTP/1.0 200 Premium Removed Successfully");
        return json_encode($data);
    } else {
        $data = [
            'status' => 500,
            'message' => 'Internal Server Error',
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
    }
}

function getPremiumMealFunc($mealID)
{

    global $conn;

    if ($mealID['id'] == null) {

        return error422('Enter meal ID');

    }

    $ID = mysqli_real_escape_string($conn, $mealID['id']);

    $query = "SELECT r.image, r.title, r.date, r.description, r.time, r.people, r.kcal, r.mealoption, ing.name AS ingredient_name, ing.weight AS ingredient_weight
          FROM react_php_recipe_premium as r
          LEFT JOIN react_php_ingredient_premium as ing ON r.id = ing.mealid
          WHERE r.id = '$ID'";


    $result = mysqli_query($conn, $query);

    if ($result) {

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
                    $data['data']['image'] = $row->image;
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


function getPremiumMealsFunc()
{
    global $conn;

    $query = "SELECT id, image, title, date, description, time, people, kcal, mealoption FROM react_php_recipe_premium";
    $result = mysqli_query($conn, $query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {

            $res = mysqli_fetch_all($result, MYSQLI_ASSOC);

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