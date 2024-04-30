<?php
    require_once('config.php');

    if ($db->userIsAlreadyLogged()) {
        $GLOBALS['log']->logInfo('Welcome in notifications page');
        $templateParams['title'] = 'Notifications';
        $templateParams['page'] = 'page.php';
        $templateParams['subpage'] = 'page_notifications.php';
        $templateParams['css'][] = 'notifications.css';
    } else {
        header('Location: ./');
        exit;
    }

    require('templates/base.php');
?>