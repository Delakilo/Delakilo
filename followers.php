<?php
    require_once('config.php');

    if ($db->userIsAlreadyLogged()) {
        $GLOBALS['log']->logInfo('Welcome in followers page');
        $templateParams['title'] = 'Followers';
        $templateParams['page'] = 'page.php';
        $templateParams['subpage'] = 'page_followers.php';
        $templateParams['css'][] = 'followers.css';
        $templateParams['user_id'] = $_GET['user_id'];
    } else {
        header('Location: ./');
        exit;
    }

    require('templates/base.php');
?>