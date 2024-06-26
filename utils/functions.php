<?php

function link_to($page) {
    header('Location: '.DIR_BASE.$page);
    exit;
}

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

function sec_session_end() {
    // Clears session
    $_SESSION = array();
    $params = session_get_cookie_params();
    // Clears cookies
    setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    session_destroy();
}

function get_user_id() {
    return $_SESSION['user_id'];
}

function get_username() {
    return $_SESSION['username'];
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

// USERS management
function get_users_dir_path($user_id) {
    return DIR_USERS.$user_id.'/';
}
function get_current_users_dir_path() {
    return get_users_dir_path($_SESSION['user_id']);
}

function get_user_dir_posts_path($user_id) {
    return get_users_dir_path($user_id).'posts/';
}
function get_current_user_dir_posts_path() {
    return get_user_dir_posts_path($_SESSION['user_id']);
}

function get_user_post_path($user_id, $imageName) {
    return get_user_dir_posts_path($user_id).$imageName;
}
function get_current_user_post_path($imageName) {
    return get_current_user_dir_posts_path().$imageName;
}

function get_user_profile($user_id, $imageName) {
    return get_users_dir_path($user_id).$imageName;
}
function get_current_user_profile($imageName) {
    return get_current_users_dir_path().$imageName;
}

function create_user_dirs($user_id, $imageName) {
    return mkdir(get_users_dir_path($user_id))
        && mkdir(get_user_dir_posts_path($user_id))
        && copy(IMG_DEFAULT_PROFILE, get_users_dir_path($user_id).$imageName);
}

function get_relative_path($from, $to) {
    $from = is_dir($from) ? rtrim($from, '\/') . '/' : $from;
    $to   = is_dir($to)   ? rtrim($to, '\/') . '/'   : $to;
    $from = str_replace('\\', '/', $from);
    $to   = str_replace('\\', '/', $to);

    $from     = explode('/', $from);
    $to       = explode('/', $to);
    $relPath  = $to;

    $to_length = count($to);
    foreach ($from as $depth => $dir) {
        if ($to_length > $depth &&  $dir === $to[$depth]) {
            array_shift($relPath);
        } else {
            $remaining = count($from) - $depth;
            if (end($from) === '') {
                $remaining = $remaining - 1;
            }
            if ($remaining > 0) {
                for ($counter = $remaining; $counter > 0; $counter--) {
                    array_unshift($relPath, '..');
                }
            } else {
                array_unshift($relPath, '.');
            }
            break;
        }
    }
    return implode('/', $relPath);
}

?>