<!-- Enrico Marchionni & Francesco Filippini & Alessandro Verna -->
<?php
    require_once('config.php');

    if ($db->userIsAlreadyLogged()) {
        $GLOBALS['log']->logInfo('Welcome in home page (his session in still active)');
        header('Location: ./home.php');
    } else {
        $GLOBALS['log']->logInfo('Unknown welcome in login page');
        header('Location: ./login.php?page=signin');
    }
    exit;
?>