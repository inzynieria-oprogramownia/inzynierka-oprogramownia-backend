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


?>