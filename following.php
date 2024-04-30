<?php
    require_once('config.php');

    if ($db->userIsAlreadyLogged()) {
        $GLOBALS['log']->logInfo('Welcome in following page');
        $templateParams['title'] = 'Following';
        $templateParams['page'] = 'page.php';
        $templateParams['subpage'] = 'page_following.php';
        $templateParams['css'][] = 'following.css';
        $templateParams['user_id'] = $_GET['user_id'];
    } else {
        header('Location: ./');
        exit;
    }

    require('templates/base.php');
?>