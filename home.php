<?php
    require_once('config.php');

    if ($db->userIsAlreadyLogged()) {
        $templateParams['title'] = 'Home';
        $templateParams['page'] = 'page.php';
        $templateParams['css'][] = 'home.css';
        $templateParams['js'][] = 'https://code.jquery.com/jquery-3.6.4.min.js';
        $templateParams['js'][] = 'js/post.js';
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