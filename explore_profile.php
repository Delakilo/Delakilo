<?php
    require_once('config.php');

    if ($db->userIsAlreadyLogged()) {
        $GLOBALS['log']->logInfo('Welcome in exploreprofile page');
        $templateParams['title'] = 'Explore';
        $templateParams['page'] = 'page.php';
        $templateParams['subpage'] = 'page_explore_profile.php';
        $templateParams['user_id'] = $_GET['user_id'];
        $templateParams['css'][] = 'exploreuserprofile.css';
    } else {
        header('Location: ./');
        exit;
    }

    require('templates/base.php');
?>