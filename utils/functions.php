<!-- Enrico Marchionni & Francesco Filippini & Alessandro Verna -->
<?php

function sec_session_start() {
    $session_name = 'sec_session_id';
    $secure = false;
    $httponly = true;
    ini_set('session.use_only_cookies', 1);
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams['lifetime'], $cookieParams['path'], $cookieParams['domain'], $secure, $httponly);
    session_name($session_name);
    session_start();
    session_regenerate_id();
}

function get_username() {
    return $_SESSION['username'];
}

function is_user_logged() {
    return isset($_SESSION['username']) && !empty($_SESSION['username']);
}

function register_logged_user($user) {
    $_SESSION['username'] = $user;
}

function sha512($value) {
    return hash('sha512', $value);
}

function generate_random_string($length) {
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $result = '';
    for ($i = 0; $i < $length; $i++) {
        $result .= $characters[mt_rand(0, strlen($characters) - 1)];
    }
    return $result;
}

?>