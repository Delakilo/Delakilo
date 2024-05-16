<?php
    require_once('../config.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $comment_text = $_POST['comment'];
        $post_id = $_POST['post_id'];

        $comment_id = $db->commentPost($post_id, $comment_text);
        ob_start();
        $comment = $db->commentsGetById($comment_id);
        require('../templates/comment.php');
        $response = array('comment' => ob_get_clean());
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        $log->logFatalError('Script called without POST method');
    }
?>
