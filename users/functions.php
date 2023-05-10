<?PHP

require '..\DBconnect.php';

function getAllUsers(){
    global $conn;

    $query = "SELECT * FROM react_php_users";
    $result = mysqli_query($conn, $query);

    if ($result){
        if (mysqli_num_rows($result) > 0){

            $res = mysqli_fetch_all($result,MYSQLI_ASSOC);

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
                'messeage' => $method. 'No Customer Fount',
            ];
            header("HTTP/1.0 404 No Customer Fount");
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

function error422($mess){
    $data = [
        'status' => 422,
        'messeage' => $mess,
    ];
    header("HTTP/1.0 500 Unprocessable Entity");
    echo json_encode($data);
    exit();
}

function addUserFunc($addUser){
    global $conn;

    $login = mysqli_real_escape_string($conn, $addUser['login']);
    $email = mysqli_real_escape_string($conn, $addUser['email']);
    $password = mysqli_real_escape_string($conn, $addUser['password']);

    if (empty(trim($login))){

        return error422('Enter your login');

    } elseif (empty(trim($email))){

        return error422('Enter your email');

    } elseif (empty(trim($password))){

        return error422('Enter your password');

    } else {
        $query = "INSERT INTO react_php_users (email, login, password) VALUES ('$email', '$login', '$password')";
        $result = mysqli_query($conn, $query);

        if ($result){
            
            $data = [
                'status' => 201,
                'message' => 'User Created Successfully',
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