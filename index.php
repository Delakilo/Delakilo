<?php
    require_once('bootstrap.php');

    if ($db->userIsAlreadyLogged()) {
        link_to('home.php');
    } else {
        link_to('login.php?page=signin');
    }
    exit;
?>