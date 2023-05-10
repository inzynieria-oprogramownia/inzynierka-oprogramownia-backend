<?PHP

require 'DBconnect.php';

function getCustomerList(){
    global $conn;

    $query = "SELECT * FROM react_php";
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

?>