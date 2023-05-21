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

function getWieghtFunc($userID){

    global $conn;

    if ($userID['id'] == null){

        return error422('Enter ID');

    } 

    $ID = mysqli_real_escape_string($conn, $userID['id']);

    $query = "SELECT weight, date FROM react_php_user_weight WHERE userid='$ID' ORDER BY date";
    $result = mysqli_query($conn,$query);

    if ($result){
        
        if (mysqli_num_rows($result) >= 1) {

            $res = mysqli_fetch_all($result,MYSQLI_ASSOC);

            $data = [
                'status' => 200,
                'messeage' => 'Record Found',
                'data' => $res
            ];
            header("HTTP/1.0 200 Success");
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
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
    }

}

function addWeightFunc($addWeight){
    
    global $conn;

    $userid = mysqli_real_escape_string($conn, $addWeight['userid']);
    $date = date('Y.m.d');
    $weight = mysqli_real_escape_string($conn, $addWeight['weight']);


    if (empty(trim($userid))) {

        return error422('Enter user ID');

    } elseif (empty(trim($weight))) {

        return error422('Enter weight');

    } else {
        $query = "INSERT INTO react_php_user_weight (userid, weight, date) VALUES ('$userid', '$weight', '$date')";
        $result = mysqli_query($conn, $query);

        if ($result){
            
            $data = [
                'status' => 201,
                'message' => 'Weight Added Successfully',
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

function updateWeightFunc($input, $params){
    global $conn;

    if (!isset($params['id'])){
        return error422('User id not found in a link');
    } elseif (empty($params['id'])) {
        return error422('Enter id');
    }

    $ID = mysqli_real_escape_string($conn, $params['id']);

    $weight = mysqli_real_escape_string($conn, $input['weight']);
    $date = date("Y-m-d");
    

    $query = "UPDATE react_php_user_weight SET weight='$weight' WHERE id='$ID' AND date='$date';";
    $result = mysqli_query($conn, $query);

    if ($result){
        $data = [
            'status' => 200,
            'message' => 'Weight Updated Successfully',
        ];
        header("HTTP/1.0 200 Weight Updated Successfully");
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


?>