<?php
    require_once('config.php');

    if ($db->userIsAlreadyLogged()) {
        $GLOBALS['log']->logInfo('Welcome in exploreprofile page');
        $templateParams['title'] = 'Explore';
        $templateParams['page'] = 'page.php';
        $templateParams['subpage'] = 'exploresearchresults.php';
        $templateParams['css'][] = 'exploresearch.css';
    } else {
        header('Location: ./');
        exit;
    }

    require('templates/base.php');
?>