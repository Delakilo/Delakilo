<?php
    require_once('config.php');

    if ($db->userIsAlreadyLogged()) {
        sec_session_end();
    }

    header('Location: ./');
    exit;
?>
