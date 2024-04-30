<?php
    require_once('config.php');

    if ($db->userIsAlreadyLogged()) {
        $GLOBALS['log']->logInfo('Welcome in exploreprofile page');
        $templateParams['title'] = 'Explore';
        $templateParams['page'] = 'page.php';
        $templateParams['subpage'] = 'page_explore_search.php';
        $templateParams['css'][] = 'exploresearch.css';
    } else {
        header('Location: ./');
        exit;
    }

    require('templates/base.php');
?>