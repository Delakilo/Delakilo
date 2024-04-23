<!-- Francesco Filippini -->
<?php
    require_once('config.php');
    
    if (is_user_logged()) {
        $GLOBALS['log']->logInfo(get_username().' welcome in home page, from loginHome');
        $templateParams['page'] = 'page.php';
        $templateParams['subpage'] = 'home.php';
        $templateParams['css'][1] = 'home.css';
    }
    
    require('templates/base.php');
?>