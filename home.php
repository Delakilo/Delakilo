<!-- Francesco Filippini -->
<?php
    require_once('config.php');

    if ($db->userIsAlreadyLogged()) {
        $GLOBALS['log']->logInfo('Welcome in home page');
        $templateParams['title'] = 'Home';
        $templateParams['page'] = 'page.php';
        $templateParams['subpage'] = 'homepage.php';
        $templateParams['css'][1] = 'home.css';
    } else {
        header('Location: ./');
        exit;
    }

    require('templates/base.php');
?>