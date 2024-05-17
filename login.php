<?php
    require_once('bootstrap.php');

    if ($db->userIsAlreadyLogged()) {
        header('Location: ./home.php');
        exit;
    }

    if (isset($_POST['username'])) {
        if (isset($_POST['pwd'])) {
            if (!$GLOBALS['db']->userLogin($_POST['username'], $_POST['pwd'])) {
                if ($GLOBALS['db']->userExists($_POST['username'])) {
                    $templateParams['error'] = 'Wrong password';
                    $GLOBALS['log']->logInfo($_POST['username'].' username tried wrong password in login');
                } else {
                    $templateParams['error'] = 'Wrong username';
                    $GLOBALS['log']->logInfo($_POST['username'].' username invalid in login');
                }
            } else {
                $GLOBALS['log']->logInfo('Logged in');
                header('Location: ./home.php');
                exit;
            }
        } else if (isset($_POST['pwd1'])) {
            if ($GLOBALS['db']->userExists($_POST['username'])) {
                $templateParams['error'] = $_POST['username'].' username yet in use';
                $GLOBALS['log']->logInfo($_POST['username'].' cannot register, username yet present in database');
            } else {
                $GLOBALS['db']->userRegister($_POST['username'], $_POST['pwd1']);
                $GLOBALS['log']->logInfo($_POST['username'].' registered');
            }
        } else {
            $GLOBALS['log']->logError($_POST['username'].' invalid data in login form');
        }
    }

    if (!isset($_GET['page'])
            || count($_GET) != 1
            || ($_GET['page'] !== 'signin' && $_GET['page'] !== 'signup')) {
        $GLOBALS['log']->logError('Login has bad set GET page in URL');
        header('Location: ./');
        exit;
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
