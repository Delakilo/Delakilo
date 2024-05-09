<!-- Francesco Filippini -->
<?php foreach($db->commentsGetByPost($templateParams['id_post']) as $comments): ?>
<?php
    if ($db->commentIsLiked($comments['IdComment'])) {
        $image = ICON_HEART_RED;
        $alt = "UnlikeComment";
    } else {
        $image = ICON_HEART_EMPTY;
        $alt = "LikeComment";
    }
?>
<section>
    <header>
        <img src="<?php echo get_user_profile($comments['EkIdUser'], $comments['imageURL']); ?>" alt=""/>
        <h2><a href="home.php?user_id=<?php echo $comments['EkIdUser']; ?>"><?php echo $comments['username'] ?></a></h2>
    </header>
    <p><?php echo $comments['content'] ?></p>
    <footer>
        <button type="button" onclick="toggleCommentLike(<?php echo $comments['IdComment']; ?>)" class="img"><img id="<?php echo $comments['IdComment']; ?>" src="<?php echo $image; ?>" alt="<?php echo $alt; ?>"/></button>
    </footer>
    <p><small><?php echo $comments['timestamp'] ?></small></p>
</section>
<?php endforeach; ?>
<section>
    <header>
        <img src="<?php echo get_current_user_profile($db->userGetMyImageProfile()); ?>" alt=""/>
        <h2><a href=""><?php echo get_username(); ?></a></h2>
    </header>
    <form id="commentForm" action="" method='POST' onsubmit="submitComment(event, <?php echo $templateParams['id_post']; ?>)">
        <h2>Comment</h2>
        <ul>
            <li><label for="add_comment" hidden>Add a comment:</label><textarea id="add_comment" name="add_comment" placeholder="Add a comment..."></textarea></li>
            <li><label for="publish" hidden>Publish:</label><input id="publish" type="submit" value="Publish"/></li>
        </ul>
    </form>
</section>