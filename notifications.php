<?php
    require_once('bootstrap.php');

    $templateParams['title'] = 'Notifications';
    $templateParams['page'] = 'page.php';
    $templateParams['subpage'] = 'page_notifications.php';
    $templateParams['css'][] = 'notifications.css';
    $templateParams['js'][] = 'js/sticky_menu.js';

    require('templates/base.php');
?>