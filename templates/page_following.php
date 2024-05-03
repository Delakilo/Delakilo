<?php
    $users = $db->userGetFollowing($templateParams['user_id']);
    require('templates/list_users.php');
?>
