<?php

require '..\..\DBconnect.php';

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

function addPostFunc($addPost)
{
    global $conn;

    $title = mysqli_real_escape_string($conn, $addPost['title']);
    $userID = mysqli_real_escape_string($conn, $addPost['userID']);
    $date = date('Y.m.d');

    if (empty(trim($title))) {

        return error422('Enter title');

    } elseif (empty(trim($userID))) {

        return error422('Enter userID');

    } else {
        $targetDirectory = 'post_image/' . $userID . '/';
        if (!is_dir($targetDirectory)) {
            mkdir($targetDirectory, 0755, true);
        }
        $targetFile = $targetDirectory . basename($_FILES["image"]["name"]);

        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $allowedExtensions = array('jpg', 'jpeg', 'png');

        if (!in_array($imageFileType, $allowedExtensions)) {
            return error422('Invalid image file type');
        }

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {

            $query = "INSERT INTO react_php_blog (userid, title, image, date) VALUES ('$userID', '$title', '$targetFile', '$date')";
            $result = mysqli_query($conn, $query);

            if ($result) {
                $postId = mysqli_insert_id($conn);

                if (isset($addPost['sections']) && is_array($addPost['sections'])) {
                    $sections = $addPost['sections'];

                    foreach ($sections as $section) {
                        $sectionName = mysqli_real_escape_string($conn, $section['name']);
                        $sectionDescription = mysqli_real_escape_string($conn, $section['description']);
                        $sectionQuery = "INSERT INTO react_php_blog_sections (postid, name, description) VALUES ('$postId', '$sectionName', '$sectionDescription')";
                        $sectionResult = mysqli_query($conn, $sectionQuery);

                        if (!$sectionResult) {
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


function getPostFunc($getPost)
{
    global $conn;

    if ($getPost['id'] == null) {
        return error422('Enter post ID');
    }

    $ID = mysqli_real_escape_string($conn, $getPost['id']);

    $query = "SELECT b.title, b.image, b.date, bs.name AS section_name, bs.description AS section_description, u.login, c.comment
              FROM react_php_blog AS b 
              LEFT JOIN react_php_blog_sections AS bs ON bs.postid = b.id
              LEFT JOIN react_php_comments AS c ON c.postid = b.id
              LEFT JOIN react_php_users AS u ON u.id=c.userid
              WHERE b.id = '$ID'";

    $result = mysqli_query($conn, $query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $data = [
                'status' => 200,
                'message' => 'Post Found',
                'data' => [
                    'sections' => [],
                    'comments' => [],
                ],
            ];

            while ($row = mysqli_fetch_object($result)) {
                if (!isset($data['data']['title'])) {
                    $data['data']['title'] = $row->title;
                    $data['data']['image'] = $row->image;
                    $data['data']['date'] = $row->date;
                }

                $section = new stdClass();
                $section->name = $row->section_name;
                $section->description = $row->section_description;
                if (!in_array($section, $data['data']['sections'])) {
                    $data['data']['sections'][] = $section;
                }

                $comment = new stdClass();
                $comment->login = $row->login;
                $comment->comment = $row->comment;
                if (!in_array($comment, $data['data']['comments'])) {
                    $data['data']['comments'][] = $comment;
                }
            }

            header("HTTP/1.0 200 Success");
            return json_encode($data);
        } else {
            $data = [
                'status' => 404,
                'message' => 'No Post Found',
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
function findPostIndex($posts, $key, $value) {
    foreach ($posts as $index => $post) {
        if ($post[$key] == $value) {
            return $index;
        }
    }
    return -1;
}
function getPostsFunc()
{
    global $conn;
 
    $query = "SELECT b.id, b.title, b.image, b.date, bs.name AS section_name, bs.description AS section_description, u.login, c.comment
              FROM react_php_blog AS b 
              LEFT JOIN react_php_blog_sections AS bs ON bs.postid = b.id
              LEFT JOIN react_php_comments AS c ON c.postid = b.id
              LEFT JOIN react_php_users AS u ON u.id=c.userid
              ORDER BY b.id";
 
    $result = mysqli_query($conn, $query);
 
    if ($result) {
        if (mysqli_num_rows($result) > 0) {
 
            $data = [
                'status' => 200,
                'message' => 'Posts Found',
                'data' => [
                    'posts' => [],
                ],
            ];
 
            while ($row = mysqli_fetch_object($result)) {
                $postId = $row->id;
 
                $postIndex = findPostIndex($data['data']['posts'], 'id', $postId);
 
                if ($postIndex === -1) {
                    $post = [
                        'id' => $postId,
                        'title' => $row->title,
                        'image' => $row->image,
                        'date' => $row->date,
                        'sections' => [],
                        'comments' => [],
                    ];
 
                    $data['data']['posts'][] = $post;
                    $postIndex = count($data['data']['posts']) - 1;
                }
 
                $section = new stdClass();
                $section->name = $row->section_name;
                $section->description = $row->section_description;
                if (!in_array($section, $data['data']['posts'][$postIndex]['sections'])) {
                    $data['data']['posts'][$postIndex]['sections'][] = $section;
                }
 
                $comment = new stdClass();
                $comment->login = $row->login;
                $comment->comment = $row->comment;
                if (!in_array($comment, $data['data']['posts'][$postIndex]['comments'])) {
                    $data['data']['posts'][$postIndex]['comments'][] = $comment;
                }
            }
            header("HTTP/1.0 200 OK");
            return json_encode($data);
 
        } else {
            $data = [
                'status' => 404,
                'message' => 'No Posts Found',
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


function getUsersPostFunc($getPost)
{
    global $conn;

    if ($getPost['userid'] == null) {
        return error422('Enter user ID');
    }

    $ID = mysqli_real_escape_string($conn, $getPost['userid']);

    $query = "SELECT b.id, b.title, b.image, b.date, bs.name AS section_name, bs.description AS section_description, u.login, c.comment
    FROM react_php_blog AS b 
    LEFT JOIN react_php_blog_sections AS bs ON bs.postid = b.id
    LEFT JOIN react_php_comments AS c ON c.postid = b.id
    LEFT JOIN react_php_users AS u ON u.id=c.userid
    WHERE b.userid = '$ID'";

    $result = mysqli_query($conn, $query);

    if ($result) {
        $data = [
            'status' => 200,
            'message' => 'Users Post Found',
            'data' => [
                'posts' => [],
            ],
        ];

        $posts = [];

        while ($row = mysqli_fetch_object($result)) {
            $postId = $row->id;

            if (!isset($posts[$postId])) {
                $posts[$postId] = [
                    'id' => $postId,
                    'title' => $row->title,
                    'image' => $row->image,
                    'date' => $row->date,
                    'sections' => [],
                    'comments' => [],
                ];
            }

            $section = new stdClass();
            $section->name = $row->section_name;
            $section->description = $row->section_description;
            if (!in_array($section, $posts[$postId]['sections'])) {
                $posts[$postId]['sections'][] = $section;
            }

            $comment = new stdClass();
            $comment->login = $row->login;
            $comment->comment = $row->comment;
            if (!in_array($comment, $posts[$postId]['comments'])) {
                $posts[$postId]['comments'][] = $comment;
            }
        }

        // Konwersja tablicy pomocniczej na indeksowaną tablicę wynikową
        $data['data']['posts'] = array_values($posts);


        header("HTTP/1.0 200 Success");
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