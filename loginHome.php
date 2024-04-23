<!-- Francesco Filippini -->
<?php
    require_once('config.php');
    
    if ($db->userLoginCheck()) {
        $GLOBALS['log']->logInfo(get_username().' welcome in home page, from loginHome');
        $templateParams['page'] = 'page.php';
        $templateParams['subpage'] = 'home.php';
        $templateParams['css'][1] = 'home.css';
    } else {
        header('Location: ./index.php');
    }
    
    require('templates/base.php');
?>