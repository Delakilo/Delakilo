<?php
    require_once('config.php');

    if ($_SERVER['SCRIPT_NAME'] !== DIR_BASE.'index.php' && $_SERVER['SCRIPT_NAME'] !== DIR_BASE.'login.php') {
        if (!$db->userIsAlreadyLogged()) {
            $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
            link_to('');
        }
    }
?>
