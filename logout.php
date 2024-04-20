<!-- Enrico Marchionni -->
<?php
    require_once('config.php');
    // Clears session
    $_SESSION = array();
    $params = session_get_cookie_params();
    // Clears cookies
    setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    session_destroy();
    header('Location: ./');
?>