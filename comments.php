<?php
    require_once('config.php');

    if ($db->userIsAlreadyLogged()) {
        $templateParams['title'] = 'Comments';
        $templateParams['page'] = 'page.php';
        $templateParams['subpage'] = 'comment.php';
        $templateParams['css'][] = 'comments.css';
    } else {
        header('Location: ./');
        exit;
    }

    require('templates/base.php');
?>