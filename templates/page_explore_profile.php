<!-- Alessandro Verna -->
<?php foreach($db->userGetInfoById($templateParams['user_id']) as $info): ?>
<section>
    <h2><?php echo $info['username']; ?></h2>
    <div>
        <img src="<?php echo get_user_profile($templateParams['user_id'], $info['imageURL']); ?>" alt=""/>
        <ul>
            <li><em><?php echo $info['nPosts']; ?><br/>Posts</em></li><li><a href="./followers.php"><em><?php echo $info['nFollowers']; ?><br/>Followers</em></a></li><li><a href="./following.php"><em><?php echo $info['nFollowing']; ?><br/>Following</em></a></li>
        </ul>
    </div>
    <p><strong><?php echo $info['name'].$info['surname']; ?></strong></p>
    <p><small><?php echo $info['bio']; ?></small></p>
    <footer>
        <p><a href="">Follow</a></p>
    </footer>
</section>
<?php endforeach; ?>
<?php foreach($db->postsGetFromUser($templateParams['user_id']) as $post): ?>
<article>
    <figure>
        <?php 
            echo '<img src='.get_user_post_path($post['EkIdUser'], $post['imageURL']).' alt="" />';
            echo "<figcaption>".$post['caption']."</figcaption>";
        ?>
    </figure>
    <footer>
        <form action="" method="POST">
            <ul> 
                <li><label for="like" hidden>Like:</label><input id="like" type="image" src="<?php echo ICON_HEART_EMPTY; ?>" alt="Like"/></li>
            </ul>
        </form>
        <form action="" method="GET">
            <ul> 
                <li><label for="comment" hidden>Comment:</label><input id="comment" type="image" src="<?php echo ICON_COMMENT; ?>" alt="Comment"/></li>
            </ul>
        </form>
    </footer>
    <aside>
        <img src="<?php echo IMG_DEFAULT_PROFILE; ?>" alt=""/>
        <img src="<?php echo IMG_DEFAULT_PROFILE; ?>" alt=""/>
        <img src="<?php echo IMG_DEFAULT_PROFILE; ?>" alt=""/>
        <p><small><?php echo 'Liked by '.$post['nLikes'].' users' ?></small></p>
        <p><a href="">View all comments</a></p>
        <p><small><?php echo $post['timestamp'] ?></small></p>
    </aside>
</article>
<?php endforeach; ?>
