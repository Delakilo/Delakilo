<?php
    // require_once('config.php');

    // // Get the requested URL from the query parameter
    // $url = $_SERVER['REQUEST_URI'];
    // // Remove query parameters from the URL if present
    // $url = strtok($url, '?');
    // $absolute_path = $_SERVER['DOCUMENT_ROOT'] . $url;

    // if (!file_exists($absolute_path)) {
    //     http_response_code(404);
    //     $templateParams['title'] = 'Error 404';
    //     $templateParams['page'] = 'page_error.php';
    //     $templateParams['css'][] = 'error.css';
    //     $templateParams['error']['title'] = '404 - PAGE NOT FOUND';
    //     $templateParams['error']['description'] = 'Unable to find specified page.';
    //     require('templates/base.php');
    //     exit;
    // }

    require_once('bootstrap.php');

    if ($db->userIsAlreadyLogged()) {
        $GLOBALS['log']->logInfo('Welcome in home page (his session in still active)');
        header('Location: ./home.php');
    } else {
        $GLOBALS['log']->logInfo('Unknown welcome in login page');
        header('Location: ./login.php?page=signin');
    }
    exit;
?>