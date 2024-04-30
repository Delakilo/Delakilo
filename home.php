<?php
    require_once('config.php');

    if ($db->userIsAlreadyLogged()) {
        $GLOBALS['log']->logInfo('Welcome in home page');
        $templateParams['title'] = 'Home';
        $templateParams['page'] = 'page.php';
        $templateParams['subpage'] = 'page_home.php';
        $templateParams['css'][] = 'home.css';
    } else {
        header('Location: ./');
        exit;
    }

    require('templates/base.php');
?>