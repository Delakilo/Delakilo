<!-- Francesco Filippini -->
<?php $info = $db->userGetInfoById($templateParams['user_id']); ?>
<section id="user_<?php echo $templateParams['user_id']; ?>">
    <?php if ($_SESSION['user_id'] !== $templateParams['user_id'] || $_SERVER['PHP_SELF'] != DIR_BASE.'profile.php'): ?>
    <h2><?php echo $info['username']; ?></h2>
    <?php else: ?>
    <header>
        <h2><?php echo $info['username']; ?></h2>
        <p><a href="<?php echo $_SERVER['PHP_SELF']; ?>?add_post"><img src="<?php echo ICON_PLUS; ?>" alt="Add"/></a></p>
    </header>
    <?php endif; ?>
    <div>
        <img src="<?php echo get_user_profile($templateParams['user_id'], $info['userImageName']); ?>" alt=""/>
        <ul>
            <li><?php echo $info['nPosts']; ?><br/>Posts</li><li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?user_id=<?php echo $templateParams['user_id']; ?>&followers"><?php echo $info['nFollowers']; ?><br/>Followers</a></li><li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?user_id=<?php echo $templateParams['user_id']; ?>&following"><?php echo $info['nFollowing']; ?><br/>Following</a></li>
        </ul>
    </div>
    <?php if ($info['name'] != '' && $info['surname'] != ''): ?>
        <p><strong><?php echo htmlspecialchars($info['name'], ENT_QUOTES, 'UTF-8').' '.htmlspecialchars($info['surname'], ENT_QUOTES, 'UTF-8'); ?></strong></p>
    <?php endif; ?>
    <?php if ($info['bio'] != ''): ?>
    <p><small><?php echo htmlspecialchars($info['bio'], ENT_QUOTES, 'UTF-8'); ?></small></p>
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
        <button type="button" onclick="toggleFollow(<?php echo $templateParams['user_id']; ?>)" class="text"><?php echo $text; ?></button>
    <?php elseif ($_SERVER['PHP_SELF'] == DIR_BASE.'profile.php'): ?>
        <button type="button" onclick="location.href='<?php echo $_SERVER['PHP_SELF']; ?>?edit'" class="text">Edit profile</button>
    <?php endif; ?>
    </footer>
</section>
<?php
    $posts = $db->postsGetFromUser($templateParams['user_id']);
    require('templates/posts.php');
?>
