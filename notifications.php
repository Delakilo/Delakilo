<?php
    require_once('bootstrap.php');

    $GLOBALS['log']->logInfo('Welcome in notifications page');
    $templateParams['title'] = 'Notifications';
    $templateParams['page'] = 'page.php';
    $templateParams['subpage'] = 'page_notifications.php';
    $templateParams['css'][] = 'notifications.css';
    $templateParams['js'][] = 'js/sticky_menu.js';

    require('templates/base.php');
?>