<?php foreach($posts as $post): ?>
<?php
    if ($db->postIsLiked($post['IdPost'])) {
        $image = ICON_HEART_RED;
        $alt = "UnlikePost";
    } else {
        $image = ICON_HEART_EMPTY;
        $alt = "LikePost";
    }
?>
<article id="post_<?php echo $post['IdPost']; ?>">
    <?php if (isset($post['username'])): ?>
    <header>
        <img src="<?php echo get_user_profile($post['EkIdUser'], $post['userImageName']); ?>" alt=""/>
        <h2><a href="<?php echo $_SERVER['PHP_SELF']; ?>?user_id=<?php echo $post['EkIdUser']; ?>"><?php echo $post['username'] ?></a></h2>
    </header>
    <?php endif; ?>
    <figure>
        <img src="<?php echo get_user_post_path($post['EkIdUser'], $post['IdPost'].$post['postImageExtension']) ?>" alt=""/>
        <figcaption><?php echo htmlspecialchars($post['caption'], ENT_QUOTES, 'UTF-8'); ?></figcaption>
    </figure>
    <footer>
        <button type="button" onclick="togglePostLike(<?php echo $post['IdPost']; ?>)" class="img"><img src="<?php echo $image; ?>" alt="<?php echo $alt; ?>"/></button>
        <button type="button" onclick="location.href='<?php echo $_SERVER['PHP_SELF']; ?>?id_post=<?php echo $post['IdPost']; ?>'" class="img"><img src="<?php echo ICON_COMMENT; ?>" alt="Comment"/></button>
    </footer>
    <aside>
    <?php if ($post['nLikes'] >= 3):
        $images = $db->postUsersLike($post['IdPost']);
        foreach ($images as $image): ?>
            <img src="<?php echo get_user_profile($image['IdUser'], $image['userImageName']); ?>" alt=""/>
        <?php endforeach; ?>
    <?php else: ?>
        <img src="<?php echo IMG_DEFAULT_PROFILE; ?>" alt=""/>
        <img src="<?php echo IMG_DEFAULT_PROFILE; ?>" alt=""/>
        <img src="<?php echo IMG_DEFAULT_PROFILE; ?>" alt=""/>
    <?php endif; ?>
        <p><small>Liked by <?php echo $post['nLikes']; ?> users</small></p>
        <p><a href="<?php echo $_SERVER['PHP_SELF']; ?>?id_post=<?php echo $post['IdPost']; ?>">View all comments</a></p>
        <p><small><?php echo $post['timestamp'] ?></small></p>
    </aside>
</article>
<?php endforeach; ?>
