<?php
    require_once('bootstrap.php');

    $templateParams['title'] = 'Explore';
    $templateParams['page'] = 'page.php';
    $templateParams['js'][] = 'js/sticky_menu.js';
    if (isset($_GET['id_post'])) {
        $templateParams['title'] .= ' Comments';
        $templateParams['subpage'] = 'comments.php';
        $templateParams['css'][] = 'comments.css';
        $templateParams['css'][] = 'templates/navexplore.css';
        $templateParams['id_post'] = $_GET['id_post'];
        $templateParams['js'][] = 'https://code.jquery.com/jquery-3.6.4.min.js';
        $templateParams['js'][] = 'js/comments.js';
    } else if (isset($_GET['user_id'])) {
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
            $templateParams['subpage'] = 'page_profile.php';
            $templateParams['user_id'] = $_GET['user_id'];
            $templateParams['css'][] = 'exploreuserprofile.css';
            $templateParams['js'][] = 'https://code.jquery.com/jquery-3.6.4.min.js';
            $templateParams['js'][] = 'js/post.js';
            $templateParams['js'][] = 'js/user_profile.js';
        }
    } else if (isset($_GET['search'])) {
        $templateParams['title'] .= ' Search';
        $templateParams['subpage'] = 'page_explore_search.php';
        $templateParams['css'][] = 'exploresearch.css';
    } else {
        $templateParams['subpage'] = 'page_explore.php';
        $templateParams['css'][] = 'exploreposts.css';
        $templateParams['js'][] = 'https://code.jquery.com/jquery-3.6.4.min.js';
        $templateParams['js'][] = 'js/post.js';
    }

    require('templates/base.php');
?>