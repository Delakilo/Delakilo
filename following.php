<?php
    require_once('config.php');

    if ($db->userIsAlreadyLogged()) {
        $GLOBALS['log']->logInfo('Welcome in following page');
        $templateParams['title'] = 'Following';
        $templateParams['page'] = 'page.php';
        $templateParams['subpage'] = 'follow.php';
        $templateParams['css'][] = 'following.css';
    } else {
        header('Location: ./');
        exit;
    }

    require('templates/base.php');
?>