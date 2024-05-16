<?php
    require_once('config.php');

    if (!$db->userIsAlreadyLogged()) {
        header('Location: ./');
        exit;
    }

    $templateParams['title'] = 'Profile';
    $templateParams['page'] = 'page.php';
    $templateParams['user_id'] = $_SESSION['user_id'];

    if (isset($_GET['edit'])) {
        $templateParams['title'] .= ' Edit';
        $templateParams['subpage'] = 'templates/page_profile_edit.php';
        $templateParams['css'][] = 'myprofileedit.css';
    } else if (isset($_GET['id_post'])) {
            $templateParams['title'] .= ' Comments';
            $templateParams['subpage'] = 'comments.php';
            $templateParams['css'][] = 'comments.css';
            $templateParams['css'][] = 'templates/navprofile.css';
            $templateParams['id_post'] = $_GET['id_post'];
            $templateParams['js'][] = 'https://code.jquery.com/jquery-3.6.4.min.js';
            $templateParams['js'][] = 'js/comments.js';
    } else if (isset($_GET['user_id'])) {
            if (isset($_GET['followers'])) {
                $templateParams['title'] .= ' Followers';
                $templateParams['subpage'] = 'page_followers.php';
                $templateParams['css'][] = 'templates/navprofile.css';
                $templateParams['css'][] = 'followers.css';
                $templateParams['user_id'] = $_GET['user_id'];
            } else if (isset($_GET['following'])) {
                $templateParams['title'] .= ' Following';
                $templateParams['subpage'] = 'page_following.php';
                $templateParams['css'][] = 'templates/navprofile.css';
                $templateParams['css'][] = 'following.css';
                $templateParams['user_id'] = $_GET['user_id'];
            } else {
                $templateParams['subpage'] = 'templates/page_profile.php';
                $templateParams['js'][] = 'https://code.jquery.com/jquery-3.6.4.min.js';
                $templateParams['js'][] = 'js/sticky_menu.js';
                $templateParams['js'][] = 'js/post.js';
                $templateParams['js'][] = 'js/user_profile.js';
                $templateParams['css'][] = 'myprofile.css';
                $templateParams['user_id'] = $_GET['user_id'];
            }
    } else if (isset($_GET['add_post'])) {
        $templateParams['subpage'] = 'templates/page_profile_add_post.php';
        $templateParams['css'][] = 'myprofileaddpost.css';
        if (isset($_GET['error_message'])) {
            $templateParams['error'] = urldecode($_GET['error_message']);
        }
    } else {
        $templateParams['subpage'] = 'templates/page_profile.php';
        $templateParams['js'][] = 'https://code.jquery.com/jquery-3.6.4.min.js';
        $templateParams['js'][] = 'js/sticky_menu.js';
        $templateParams['js'][] = 'js/post.js';
        $templateParams['css'][] = 'myprofile.css';
    }

    require('templates/base.php');
?>
