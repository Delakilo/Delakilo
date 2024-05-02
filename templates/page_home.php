<?php
    $posts = $db->postsGetFromFollowingUsers();
    require('templates/posts.php');
?>
