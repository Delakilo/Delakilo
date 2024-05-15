<!-- Francesco Filippini -->
<?php $info = $db->userGetInfoById($templateParams['user_id']); ?>
<section>
    <?php if ($_SESSION['user_id'] !== $templateParams['user_id']): ?>
    <h2><?php echo $info['username']; ?></h2>
    <?php else: ?>
    <header>
        <h2><?php echo $info['username']; ?></h2>
        <p><a href=""><img src="<?php echo ICON_PLUS; ?>" alt="Add"/></a></p>
    </header>
    <?php endif; ?>
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
    <footer>
    <?php if ($_SESSION['user_id'] !== $templateParams['user_id']): ?>
        <?php
            if ($db->userIsFollowed($templateParams['user_id'])) {
                $text = 'Unfollow';
            } else {
                $text = 'Follow';
            }
        ?>
        <button id="<?php echo $templateParams['user_id']; ?>" type="button" onclick="toggleFollow(<?php echo $templateParams['user_id']; ?>)" class="text"><?php echo $text; ?></button>
    <?php else: ?>
        <button id="<?php echo $templateParams['user_id']; ?>" type="button" onclick="location.href='<?php echo $_SERVER['PHP_SELF']; ?>?edit'" class="text">Edit profile</button>
    <?php endif; ?>
    </footer>
</section>
<?php
    $posts = $db->postsGetFromUser($templateParams['user_id']);
    require('templates/posts.php');
?>
