<?php
    $users = $db->userGetFollowers($templateParams['user_id']);
    require('templates/list_users.php');
?>
