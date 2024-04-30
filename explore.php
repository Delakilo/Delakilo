<?php
    require_once('config.php');

    if ($db->userIsAlreadyLogged()) {
        $GLOBALS['log']->logInfo('Welcome in explore page');
        $templateParams['title'] = 'Explore';
        $templateParams['page'] = 'page.php';
        $templateParams['subpage'] = 'explorepage.php';
        $templateParams['css'][] = 'exploreposts.css';
    } else {
        header('Location: ./');
        exit;
    }

    require('templates/base.php');
?>