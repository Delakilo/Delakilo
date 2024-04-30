<?php
    require_once('config.php');

    if ($db->userIsAlreadyLogged()) {
        $templateParams['title'] = 'Home';
        $templateParams['page'] = 'page.php';
        $templateParams['css'][] = 'home.css';
        if (isset($_GET['user_id'])) {
            $GLOBALS['log']->logInfo('Welcome in homeprofile page');
            $templateParams['subpage'] = 'page_home_profile.php';
            $templateParams['user_id'] = $_GET['user_id'];
        } else {
            $GLOBALS['log']->logInfo('Welcome in home page');
            $templateParams['subpage'] = 'page_home.php';
        }
    } else {
        header('Location: ./');
        exit;
    }

    require('templates/base.php');
?>