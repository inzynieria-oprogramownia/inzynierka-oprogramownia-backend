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

function addCommentFunc($addComment){
    global $conn;

    $userid = mysqli_real_escape_string($conn, $addComment['userid']);
    $date = date('Y.m.d h:i:sa');
    $comment = mysqli_real_escape_string($conn, $addComment['comment']);


    if (empty(trim($userid))) {

        return error422('Enter user ID');

    } elseif (empty(trim($comment))) {

        return error422('Enter comment');

    } else {
        $query = "INSERT INTO react_php_comments (userid, comment, date) VALUES ('$userid', '$comment', '$date')";
        $result = mysqli_query($conn, $query);

        if ($result){
            
            $data = [
                'status' => 201,
                'message' => 'Comment Added Successfully',
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

function getCommentFunc($getComment){
    global $conn;

    if ($getComment['id'] == null){

        return error422('Enter comment ID');

    } 

    $ID = mysqli_real_escape_string($conn, $getComment['id']);

    $query = "SELECT u.login, c.comment, c.date FROM react_php_comments AS c
    JOIN react_php_users AS u ON c.userid=u.id
    WHERE c.id='$ID' LIMIT 1";
    
    $result = mysqli_query($conn,$query);

    if ($result){
        
        if (mysqli_num_rows($result) == 1) {
            $res = mysqli_fetch_assoc($result);

            $data = [
                'status' => 200,
                'messeage' => 'Comments Found',
                'data' => $res
            ];
            header("HTTP/1.0 200 Success");
            return json_encode($data);

        } else {
            $data = [
                'status' => 404,
                'messeage' => 'No comment Found',
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

function getAllCommentsFunc(){
    global $conn;

    $query = "SELECT u.login, c.comment, c.date FROM react_php_comments AS c
    JOIN react_php_users AS u ON c.userid=u.id";

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