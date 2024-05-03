<!-- Francesco Filippini -->
<?php foreach($db->userGetInfoById($templateParams['user_id']) as $info): ?>
<?php
    if ($db->userIsFollowed($templateParams['user_id'])) {
        $text = 'Unfollow';
    } else {
        $text = 'Follow';
    }
?>
<section>
    <h2><?php echo $info['username']; ?></h2>
    <div>
        <img src="<?php echo get_user_profile($templateParams['user_id'], $info['imageURL']); ?>" alt=""/>
        <ul>
            <li><em><?php echo $info['nPosts']; ?><br/>Posts</em></li><li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?user_id=<?php echo $templateParams['user_id']; ?>&followers"><em><?php echo $info['nFollowers']; ?><br/>Followers</em></a></li><li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?user_id=<?php echo $templateParams['user_id']; ?>&following"><em><?php echo $info['nFollowing']; ?><br/>Following</em></a></li>
        </ul>
    </div>
    <?php if ($info['name'] != '' && $info['surname'] != ''): ?>
        <p><strong><?php echo $info['name'].' '.$info['surname']; ?></strong></p>
    <?php endif; ?>
    <?php if ($info['bio'] != ''): ?>
    <p><small><?php echo $info['bio']; ?></small></p>
    <?php endif; ?>
    <footer>
        <button id="<?php echo $templateParams['user_id']; ?>" type="button" onclick="toggleFollow(<?php echo $templateParams['user_id']; ?>)"><?php echo $text; ?></button>
    </footer>
</section>
<?php endforeach; ?>
<?php
    $posts = $db->postsGetFromUser($templateParams['user_id']);
    require('templates/posts.php');
?>
