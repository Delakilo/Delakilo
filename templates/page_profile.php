<!-- Francesco Filippini -->
<?php foreach($db->userGetInfoById($templateParams['user_id']) as $info): ?>
<section>
    <h2><?php echo $info['username']; ?></h2>
    <div>
        <img src="<?php echo get_user_profile($templateParams['user_id'], $info['imageURL']); ?>" alt=""/>
        <ul>
            <li><?php echo $info['nPosts']; ?><br/>Posts</li><li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?user_id=<?php echo $templateParams['user_id']; ?>&followers"><?php echo $info['nFollowers']; ?><br/>Followers</a></li><li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?user_id=<?php echo $templateParams['user_id']; ?>&following"><?php echo $info['nFollowing']; ?><br/>Following</a></li>
        </ul>
    </div>
    <?php if ($info['name'] != '' && $info['surname'] != ''): ?>
        <p><strong><?php echo $info['name'].' '.$info['surname']; ?></strong></p>
    <?php endif; ?>
    <?php if ($info['bio'] != ''): ?>
    <p><small><?php echo $info['bio']; ?></small></p>
    <?php endif; ?>
    <?php if ($_SESSION['user_id'] !== $templateParams['user_id']): ?>
    <footer>
        <?php
            if ($db->userIsFollowed($templateParams['user_id'])) {
                $text = 'Unfollow';
            } else {
                $text = 'Follow';
            }
        ?>
        <button id="<?php echo $templateParams['user_id']; ?>" type="button" onclick="toggleFollow(<?php echo $templateParams['user_id']; ?>)"><?php echo $text; ?></button>
    </footer>
    <?php endif; ?>
</section>
<?php endforeach; ?>
<?php
    $posts = $db->postsGetFromUser($templateParams['user_id']);
    require('templates/posts.php');
?>
