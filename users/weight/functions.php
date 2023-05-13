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

        return error422('Enter user ID');

    } 

    $ID = mysqli_real_escape_string($conn, $userID['id']);

    $query = "SELECT weight, measuredate FROM react_php_user_weight WHERE userid='$ID'";
    $result = mysqli_query($conn,$query);

    if ($result){
        
        if (mysqli_num_rows($result) > 1) {

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
            'messeage' => $method. 'Internal Server Error',
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
    }

}


?>