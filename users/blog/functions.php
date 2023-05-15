<?php

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

function addPostFunc($addPost){
    global $conn;

    $title = mysqli_real_escape_string($conn, $addPost['title']);
    $image = mysqli_real_escape_string($conn, $addPost['image']);
    $date = date('Y-m-d');

    if (empty(trim($title))){

        return error422('Enter title');

    } elseif (empty(trim($image))){

        return error422('Enter image');

    } else {
        $query = "INSERT INTO react_php_blog (title, image, date) VALUES ('$title', '$image', '$date')";
        $result = mysqli_query($conn, $query);

        if ($result){
            $postId = mysqli_insert_id($conn);

            if (isset($addPost['sections']) && is_array($addPost['sections'])) {
                $sections = $addPost['sections'];

                foreach ($sections as $section) {
                    $sectionName = mysqli_real_escape_string($conn, $section['name']);
                    $sectionDescription = mysqli_real_escape_string($conn, $section['description']);
                    $sectionQuery = "INSERT INTO react_php_blog_sections (postid, name, description) VALUES ('$postId', '$sectionName', '$sectionDescription')";
                    $sectionResult = mysqli_query($conn, $sectionQuery);

                    if(!$sectionResult) {
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
                'message' => 'Post Created Successfully',
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

?>