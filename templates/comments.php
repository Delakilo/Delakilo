<!-- Francesco Filippini -->
<?php
    foreach($db->commentsGetByPostId($templateParams['id_post']) as $comment):
        require('comment.php');
    endforeach;
?>
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
