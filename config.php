<!-- Enrico Marchionni -->
<?php
    // DATES
    define('DATE_FORMAT_SHORT', 'Y-m-d');
    define('DATE_FORMAT_LONG', 'Y-m-d h:i:s A');

    // LOGIN
    define('PASSWORD_MIN_LENGTH', 10);
    define('LOGIN_HOURS_ATTEMPTS_VALIDITY', 2);
    define('LOGIN_MAX_ATTEMPTS', 5);

    // DEFAULT PATHS
    define('UPLOAD_DIR', './resources/');
    define('DEFAULT_PATH', UPLOAD_DIR.'default/');
    define('DEFAULT_PROFILE', DEFAULT_PATH.'defaultProfile.svg');
    define('LOGO', DEFAULT_PATH.'logo.svg');
    define('UPLOAD_DIR_PROFILES', UPLOAD_DIR.'profilePictures/');
    define('UPLOAD_DIR_POSTS', UPLOAD_DIR.'postPictures/');

    require_once('logging/Logger.php');
    $log = new Logger(UPLOAD_DIR.'logs/');

    require_once('utils/functions.php');

    require_once('database/DatabaseHelper.php');
    $db = new DatabaseHelper('localhost', 'root', '', 'Delakilo', 3306);

    sec_session_start();
?>
