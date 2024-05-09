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
    } else {
        $templateParams['subpage'] = 'templates/page_profile.php';
        $templateParams['js'][] = 'js/sticky_menu.js';
        $templateParams['css'][] = 'myprofile.css';
    }

    require('templates/base.php');
?>
