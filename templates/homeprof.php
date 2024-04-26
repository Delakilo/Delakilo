<!-- Francesco Filippini -->
<section>
    <h2>User2</h2>
    <div>
        <img src="<?php echo IMG_DEFAULT_PROFILE; ?>" alt=""/>
        <ul>
            <li><em>XX<br/>Posts</em></li><li><a href="./followers.php"><em>XX<br/>Followers</em></a></li><li><a href="./following.php"><em>XX<br/>Following</em></a></li>
        </ul>
    </div>
    <p><strong>Name Surname</strong></p>
    <p><small>Bio...</small></p>
    <footer>
        <p><a href="">Follow</a></p>
    </footer>
</section>                                         <!--  TODO: devo mettere l'id non dell'utente 1 ma del profilo che visito -->
<?php foreach($db->postsGetFromUser(1) as $post): ?>
<article>
    <!-- TODO: Warning: article lacks heading  -->
    <figure>
        <?php 
                echo '<img src='.get_user_post_path($post["EkIdUser"], $post["imageURL"]).' alt="" />';
                echo "<figcaption>".$post["caption"]."</figcaption>";
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
        <p><small><?php echo 'Liked by '.$post["nLikes"].' users' ?></small></p>
        <p><a href="">View all comments</a></p>
        <p><small><?php echo $post["timestamp"] ?></small></p>
    </aside>
</article>
<?php endforeach; ?>