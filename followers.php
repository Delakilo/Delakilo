<?php
    require_once('config.php');

    if ($db->userIsAlreadyLogged()) {
        $GLOBALS['log']->logInfo('Welcome in followers page');
        $templateParams['title'] = 'Followers';
        $templateParams['page'] = 'page.php';
        $templateParams['subpage'] = 'follow.php';
        $templateParams['css'][] = 'followers.css';
    } else {
        header('Location: ./');
        exit;
    }

    require('templates/base.php');
?>