<?php
    require_once('config.php');

    if ($db->userIsAlreadyLogged()) {
        $templateParams['title'] = 'Explore';
            $templateParams['page'] = 'page.php';
        if (isset($_GET['user_id'])) {
            $GLOBALS['log']->logInfo('Welcome in explore_profile page');
            $templateParams['subpage'] = 'page_explore_profile.php';
            $templateParams['user_id'] = $_GET['user_id'];
            $templateParams['css'][] = 'exploreuserprofile.css';
        } else if (isset($_GET['search'])) {
            $GLOBALS['log']->logInfo('Welcome in explore_search page');
            $templateParams['subpage'] = 'page_explore_search.php';
            $templateParams['css'][] = 'exploresearch.css';
        } else {
            $GLOBALS['log']->logInfo('Welcome in explore page');
            $templateParams['subpage'] = 'page_explore.php';
            $templateParams['css'][] = 'exploreposts.css';
        }
    } else {
        header('Location: ./');
        exit;
    }

    require('templates/base.php');
?>