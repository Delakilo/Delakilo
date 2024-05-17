<?php
    require_once('config.php');

    if ($_SERVER['SCRIPT_NAME'] !== DIR_BASE.'index.php' && $_SERVER['SCRIPT_NAME'] !== DIR_BASE.'login.php') {
        if (!$db->userIsAlreadyLogged()) {
            header('Location: ./');
            exit;
        }
    }
?>
