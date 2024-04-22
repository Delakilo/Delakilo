<!-- Enrico Marchionni -->
<?php
    require_once('config.php');

    // TODO: uncomment when implemented home.php
     if (is_user_logged()) {
         header('Location: ./');
    }

    if (isset($_POST['username'])) {
        if (isset($_POST['pwd'])) {
            if (!$GLOBALS['db']->userLogin($_POST['username'], $_POST['pwd'])) {
                if ($GLOBALS['db']->userExists($_POST['username'])) {
                    $templateParams['error'] = 'Wrong password';
                    $GLOBALS['log']->logInfo($_POST['username'].' username tried wrong password in login, from login');
                } else {
                    $templateParams['error'] = 'Wrong username';
                    $GLOBALS['log']->logInfo($_POST['username'].' username invalid in login, from login');
                }
            } else {
                $GLOBALS['log']->logInfo($_POST['username'].' logged in, from login');
            }
        } else if (isset($_POST['pwd1'])) {
            if ($GLOBALS['db']->userExists($_POST['username'])) {
                $templateParams['error'] = $_POST['username'].' username yet in use';
                $GLOBALS['log']->logInfo($_POST['username'].' cannot register, username yet present in database, from login');
            } else {
                $GLOBALS['db']->userRegister($_POST['username'], $_POST['pwd1']);
                $GLOBALS['log']->logInfo($_POST['username'].' registered, from login');
            }
        } else {
            $GLOBALS['log']->logError($_POST['username'].' invalid data in login form, from login');
        }
    }

    if (is_user_logged()) {
        $GLOBALS['log']->logInfo(get_username().' welcome in home page, from login');
        $templateParams['page'] = 'page.php';
        $templateParams['subpage'] = 'home.php';
        $templateParams['css'][1] = 'home.css';
    }

    if (count($_GET) != 1
            || !isset($_GET['page'])
            || ($_GET['page'] !== 'signin' && $_GET['page'] !== 'signup')) {
        $GLOBALS['log']->logError('Login has bad set GET page in URL, from login');
    }

    if ($_GET['page'] === 'signin') {
        $templateParams['title'] = 'Sign In';
        $templateParams['css'][0] = 'signin.css';
        $templateParams['page'] = 'signin.php';
    } else if ($_GET['page'] === 'signup') {
        $templateParams['title'] = 'Sign Up';
        $templateParams['css'][0] = 'signup.css';
        $templateParams['page'] = 'signup.php';
    }

    require('templates/base.php');
?>
