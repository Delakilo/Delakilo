<!-- Enrico Marchionni & Francesco Filippini & Alessandro Verna -->
<?php
    require_once('config.php');

    if ($db->userLoginCheck()) {
        $GLOBALS['log']->logInfo(get_username().' welcome in home page, from index (his session in still active)');
        header('Location: ./loginHome.php');
    } else {
        $GLOBALS['log']->logInfo('Unknown welcome in login page, from index');
    }

    header('Location: ./login.php?page=signin');
?>