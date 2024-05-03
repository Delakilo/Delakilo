<?php
    require_once('config.php');

    if ($db->userIsAlreadyLogged()) {
        $templateParams['title'] = 'Explore';
        $templateParams['page'] = 'page.php';
        if (isset($_GET['user_id'])) {
            if (isset($_GET['followers'])) {
                $templateParams['title'] .= ' Followers';
                $templateParams['subpage'] = 'page_followers.php';
                $templateParams['css'][] = 'templates/navexplore.css';
                $templateParams['css'][] = 'followers.css';
                $templateParams['user_id'] = $_GET['user_id'];
            } else if (isset($_GET['following'])) {
                $templateParams['title'] .= ' Following';
                $templateParams['subpage'] = 'page_following.php';
                $templateParams['css'][] = 'templates/navexplore.css';
                $templateParams['css'][] = 'following.css';
                $templateParams['user_id'] = $_GET['user_id'];
            } else {
                $templateParams['title'] .= ' Profile';
                $GLOBALS['log']->logInfo('Welcome in page_profile page');
                $templateParams['subpage'] = 'page_profile.php';
                $templateParams['user_id'] = $_GET['user_id'];
                $templateParams['css'][] = 'exploreuserprofile.css';
                $templateParams['js'][] = 'https://code.jquery.com/jquery-3.6.4.min.js';
                $templateParams['js'][] = 'js/post.js';
                $templateParams['js'][] = 'js/userprofile.js';
            }
        } else if (isset($_GET['search'])) {
            $templateParams['title'] .= ' Search';
            $GLOBALS['log']->logInfo('Welcome in explore_search page');
            $templateParams['subpage'] = 'page_explore_search.php';
            $templateParams['css'][] = 'exploresearch.css';
        } else {
            $GLOBALS['log']->logInfo('Welcome in explore page');
            $templateParams['subpage'] = 'page_explore.php';
            $templateParams['css'][] = 'exploreposts.css';
            $templateParams['js'][] = 'https://code.jquery.com/jquery-3.6.4.min.js';
            $templateParams['js'][] = 'js/post.js';
        }
    } else {
        header('Location: ./');
        exit;
    }

    require('templates/base.php');
?>