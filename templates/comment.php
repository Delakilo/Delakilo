<section>
    <header>
        <img src="<?php echo get_current_user_profile($db->userGetMyImageProfile()); ?>" alt=""/>
        <h2><a href="home.php?user_id=<?php echo get_user_id(); ?>"><?php echo get_username() ?></a></h2>
    </header>
    <p><?php echo $comment['content'] ?></p>
    <p><small><?php echo $comment['timestamp'] ?></small></p>
    <footer>
        <button type="button" onclick="toggleCommentLike(<?php echo $comment['IdComment']; ?>)" class="img"><img id="<?php echo $comment['IdComment']; ?>" src="../resources/icons/post/heart-empty.svg" alt="Like"/></button>
    </footer>
</section>