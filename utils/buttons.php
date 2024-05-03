<?php
    require_once('../config.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        switch ($_POST['action']) {
            case 'LikePost':
                $db->postLike($_POST['post_id']);
                $response = array('status' => 'OK');
                header('Content-Type: application/json');
                echo json_encode($response);
                break;
            case 'UnlikePost':
                $db->postUnlike($_POST['post_id']);
                $response = array('status' => 'OK');
                header('Content-Type: application/json');
                echo json_encode($response);
                break;
            case 'Follow':
                if ($db->userFollow($_POST['user_id'])) {
                    $response = array('status' => 'OK');
                } else {
                    $response = array('status' => 'ERROR');
                }
                header('Content-Type: application/json');
                echo json_encode($response);
                break;
            case 'Unfollow':
                if ($db->userUnfollow($_POST['user_id'])) {
                    $response = array('status' => 'OK');
                } else {
                    $response = array('status' => 'ERROR');
                }
                header('Content-Type: application/json');
                echo json_encode($response);
                break;
        }
    } else {
        // TODO: error code to find
        // http_response_code(##);
    }
?>
