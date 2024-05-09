<?php
    require_once('config.php');

    if (!$db->userIsAlreadyLogged()) {
        header('Location: ./');
        exit;
    }

    $templateParams['title'] = 'Profile';
    if (isset($_GET['edit'])) {
        $templateParams['title'] .= ' Edit';
        die('TODO');
    } else {
        $templateParams['page'] = 'page.php';
        $templateParams['subpage'] = 'templates/page_profile.php';
        $templateParams['js'][] = 'js/sticky_menu.js';
        $templateParams['user_id'] = $_SESSION['user_id'];
        $templateParams['css'][] = 'myprofile.css';
    }

    require('templates/base.php');
?>
