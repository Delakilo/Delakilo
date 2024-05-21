<?php
    require_once('bootstrap.php');

    if ($db->userIsAlreadyLogged()) {
        link_to('home.php');
    }

    if (isset($_POST['username'])) {
        if (isset($_POST['pwd'])) {
            if (!$GLOBALS['db']->userLogin($_POST['username'], $_POST['pwd'])) {
                if ($GLOBALS['db']->userExists($_POST['username'])) {
                    $templateParams['error'] = 'Wrong password';
                } else {
                    $templateParams['error'] = 'Wrong username';
                }
            } else {
                link_to('home.php');
                exit;
            }
        } else if (isset($_POST['pwd1'])) {
            if ($GLOBALS['db']->userExists($_POST['username'])) {
                $templateParams['error'] = $_POST['username'].' username yet in use';
            } else {
                $GLOBALS['db']->userRegister($_POST['username'], $_POST['pwd1']);
            }
        } else {
            $GLOBALS['log']->logError($_POST['username'].' invalid data in login form');
        }
    }

    if (!isset($_GET['page'])
            || count($_GET) != 1
            || ($_GET['page'] !== 'signin' && $_GET['page'] !== 'signup')) {
        link_to('');
    }

    $templateParams['js'][] = 'js/sha512.js';
    $templateParams['js'][] = 'js/login.js';
    if ($_GET['page'] === 'signin') {
        $templateParams['title'] = 'Sign In';
        $templateParams['css'][] = 'signin.css';
        $templateParams['page'] = 'signin.php';
    } else /* if ($_GET['page'] === 'signup') */ {
        $templateParams['title'] = 'Sign Up';
        $templateParams['css'][] = 'signup.css';
        $templateParams['page'] = 'signup.php';
    }

    require('templates/base.php');
?>
