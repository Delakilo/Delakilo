<?php
    if ($db->commentIsLiked($comment['IdComment'])) {
        $image = ICON_HEART_RED;
        $alt = "UnlikeComment";
    } else {
        $image = ICON_HEART_EMPTY;
        $alt = "LikeComment";
    }
?>
<section id="comment_<?php echo $comment['IdComment']; ?>">
    <header>
        <img src="<?php echo get_user_profile($comment['EkIdUser'], $comment['userImageName']); ?>" alt=""/>
        <h2><a href="<?php echo $_SERVER['PHP_SELF']; ?>?user_id=<?php echo $comment['EkIdUser']; ?>"><?php echo $comment['username'] ?></a></h2>
    </header>
    <p><?php echo $comment['content'] ?></p>
    <footer>
        <button type="button" onclick="toggleCommentLike(<?php echo $comment['IdComment']; ?>)" class="img"><img src="<?php echo $image; ?>" alt="<?php echo $alt; ?>"/></button>
    </footer>
    <p><small><?php echo $comment['timestamp'] ?></small></p>
</section>
