<?php
    require_once('config.php');

    if ($db->userIsAlreadyLogged()) {
        $templateParams['js'][] = 'js/sticky_menu.js';
        $templateParams['title'] = 'Comments';
        $templateParams['page'] = 'page.php';
        $templateParams['subpage'] = 'comment.php';
        $templateParams['css'][] = 'comments.css';
        if (isset($_GET['id_post'])) {
            $templateParams['id_post'] = $_GET['id_post'];
            $templateParams['js'][] = 'https://code.jquery.com/jquery-3.6.4.min.js';
            $templateParams['js'][] = 'js/comments.js';
        }
    } else {
        header('Location: ./');
        exit;
    }

    require('templates/base.php');
?>