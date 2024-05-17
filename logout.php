<?php
    require_once('bootstrap.php');

    sec_session_end();
    header('Location: ./');
    exit;
?>
