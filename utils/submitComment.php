<?php
    require_once('../config.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        $comment_text = isset($_POST['comment']) ? $_POST['comment'] : '';
        $post_id = isset($_POST['post_id']) ? $_POST['post_id'] : '';

        $comment_id = $db->commentPost($post_id, $comment_text);
        ob_start();
        $comment = $db->commentsGetById($comment_id);
        include '../templates/comment.php';
        $response = array('comment' =>  ob_get_clean());
        header('Content-Type: application/json');
        echo json_encode($response);    
    }
?>
