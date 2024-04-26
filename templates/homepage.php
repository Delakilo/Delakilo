<?php 
    foreach($db->postsGetFromFollowingUsers() as $post):
    foreach ($db->userGetInfoById($post["EkIdUser"]) as $info):
?>
<article>
    <header>
        <img src="<?php echo IMG_DEFAULT_PROFILE; ?>" alt=""/>     <!-- TODO: mettere  $info["imageURL"] ma se lo metto ora non si vede la default_image_profile-->
        <h2><a href="./homeprofile.php"><?php echo $info["username"] ?></a></h2>
    </header>
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
<?php endforeach; ?>