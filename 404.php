<?php
    require_once('config.php');

    http_response_code(404);
    $templateParams['title'] = 'Error 404';
    $templateParams['page'] = 'page_error.php';
    $templateParams['css'][] = 'error.css';
    $templateParams['error']['title'] = '404 - PAGE NOT FOUND';
    $templateParams['error']['description'] = 'Unable to find specified page.';

    require('templates/base.php');
?>