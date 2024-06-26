<?php
    require_once('bootstrap.php');

    $templateParams['title'] = 'Home';
    $templateParams['page'] = 'page.php';
    $templateParams['js'][] = 'js/sticky_menu.js';
    if (isset($_GET['id_post'])) {
        $templateParams['title'] .= ' Comments';
        $templateParams['subpage'] = 'comments.php';
        $templateParams['css'][] = 'comments.css';
        $templateParams['css'][] = 'templates/navhome.css';
        $templateParams['id_post'] = $_GET['id_post'];
        $templateParams['js'][] = 'https://code.jquery.com/jquery-3.6.4.min.js';
        $templateParams['js'][] = 'js/comments.js';
    } else if (isset($_GET['user_id'])) {
        if (isset($_GET['followers'])) {
            $templateParams['title'] .= ' Followers';
            $templateParams['subpage'] = 'page_followers.php';
            $templateParams['css'][] = 'templates/navhome.css';
            $templateParams['css'][] = 'followers.css';
            $templateParams['user_id'] = $_GET['user_id'];
        } else if (isset($_GET['following'])) {
            $templateParams['title'] .= ' Following';
            $templateParams['subpage'] = 'page_following.php';
            $templateParams['css'][] = 'templates/navhome.css';
            $templateParams['css'][] = 'following.css';
            $templateParams['user_id'] = $_GET['user_id'];
        } else {
            $templateParams['title'] .= ' Profile';
            $templateParams['subpage'] = 'page_profile.php';
            $templateParams['css'][] = 'home.css';
            $templateParams['user_id'] = $_GET['user_id'];
            $templateParams['js'][] = 'https://code.jquery.com/jquery-3.6.4.min.js';
            $templateParams['js'][] = 'js/post.js';
            $templateParams['js'][] = 'js/user_profile.js';
        }
    } else {
        $templateParams['subpage'] = 'page_home.php';
        $templateParams['css'][] = 'home.css';
        $templateParams['js'][] = 'https://code.jquery.com/jquery-3.6.4.min.js';
        $templateParams['js'][] = 'js/post.js';
    }

    require('templates/base.php');
?>