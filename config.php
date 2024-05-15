<?php
    require_once('utils/functions.php');

    // DATES
    define('DATE_FORMAT_SHORT', 'Y-m-d');
    define('DATE_FORMAT_LONG', 'Y-m-d h:i:s A');

    // LOGIN
    define('LOGIN_HOURS_ATTEMPTS_VALIDITY', 2);
    define('LOGIN_MAX_ATTEMPTS', 5);

    // DEFAULT PATHS
    // TODO: check if there is another way to refer to current project root path without writing explicitly '/Delakilo' dir name in config file
    define('DIR_BASE', '/Delakilo/');
    define('DIR_RESOURCES', get_relative_path(dirname($_SERVER['PHP_SELF']), DIR_BASE.'resources/'));

    // Icons
    define('DIR_ICONS', DIR_RESOURCES.'icons/');
    define('ICON_LOGO', DIR_ICONS.'logo.svg');

    define('DIR_ICONS_PAGE_MENU', DIR_ICONS.'page_menu/');
    define('ICON_BELL', DIR_ICONS_PAGE_MENU.'bell.svg');
    define('ICON_HOME', DIR_ICONS_PAGE_MENU.'home.svg');
    define('ICON_SEARCH', DIR_ICONS_PAGE_MENU.'search.svg');
    define('ICON_USER', DIR_ICONS_PAGE_MENU.'user.svg');

    define('DIR_ICONS_POST', DIR_ICONS.'post/');
    define('ICON_COMMENT', DIR_ICONS_POST.'comment.svg');
    define('ICON_HEART_EMPTY', DIR_ICONS_POST.'heart-empty.svg');
    define('ICON_HEART_RED', DIR_ICONS_POST.'heart-red.svg');

    define('DIR_ICONS_PROFILE', DIR_ICONS.'profile/');
    define('ICON_PLUS', DIR_ICONS_PROFILE.'plus.svg');

    // Images
    define('DIR_IMAGES', DIR_RESOURCES.'images/');
    define('IMG_DEFAULT_PROFILE', DIR_IMAGES.'profiles/default.svg');

    // Users
    define('DIR_USERS', DIR_RESOURCES.'users/');

    // Uploaded img size
    define('IMG_EXTENSIONS_ALLOWED', array("jpg", "jpeg", "png", "gif"));
    define('IMG_MAX_SIZE_MB', 5);
    define('IMG_MAX_SIZE_B', IMG_MAX_SIZE_MB * 1_024 * 1_024); // 5 MB

    require_once('logging/Logger.php');
    $log = new Logger(DIR_RESOURCES.'logs/');

    require_once('database/DatabaseHelper.php');
    $db = new DatabaseHelper('localhost', 'root', '', 'Delakilo', 3306);

    sec_session_start();
?>
