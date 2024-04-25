<?php
    require_once('config.php');

    if ($db->userIsAlreadyLogged()) {
        $GLOBALS['log']->logInfo('Welcome in homeprofile page');
        $templateParams['title'] = 'Home';
        $templateParams['page'] = 'page.php';
        $templateParams['subpage'] = 'homeprof.php';
        $templateParams['css'][] = 'home.css';
    } else {
        header('Location: ./');
        exit;
    }

    require('templates/base.php');
?>