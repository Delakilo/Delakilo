<!-- Francesco Filippini -->
<?php foreach($db->userGetInfoById($templateParams['user_id']) as $info): ?>
<section>
    <h2><?php echo $info['username']; ?></h2>
    <div>
        <img src="<?php echo get_user_profile($templateParams['user_id'], $info['imageURL']); ?>" alt=""/>
        <ul>
            <li><em><?php echo $info['nPosts']; ?><br/>Posts</em></li><li><a href="./followers.php?user_id=<?php echo $templateParams['user_id']; ?>"><em><?php echo $info['nFollowers']; ?><br/>Followers</em></a></li><li><a href="./following.php?user_id=<?php echo $templateParams['user_id']; ?>"><em><?php echo $info['nFollowing']; ?><br/>Following</em></a></li>
        </ul>
    </div>
    <?php if ($info['name'] != '' && $info['surname'] != ''): ?>
        <p><strong><?php echo $info['name'].' '.$info['surname']; ?></strong></p>
    <?php endif; ?>
    <?php if ($info['bio'] != ''): ?>
    <p><small><?php echo $info['bio']; ?></small></p>
    <?php endif; ?>
    <footer>
        <p><a href="">Follow</a></p>
    </footer>
</section>
<?php endforeach; ?>
<?php
    $posts = $db->postsGetFromUser($templateParams['user_id']);
    require('templates/posts.php');
?>
