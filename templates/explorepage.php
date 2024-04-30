<!-- Alessandro Verna -->
<section>
    <form action="exploresearch.php" method="GET">
        <ul>
            <li><label for="search_bar" hidden></label><input id="search_bar" type="text" name="SearchBar" autocomplete="on" placeholder="Search"/></li>
            <li><label for="search_btn" hidden></label><input id="search_btn" type="submit" value="Search"/></li>
        </ul>
    </form>
</section>
<?php 
    foreach($db->postsGetAll() as $post):
?>
<article>
    <header>
        <img src="<?php echo get_user_profile($post['EkIdUser'], $post['imgProfile']); ?>" alt=""/>
        <h2><a href="./exploreprofile.php?user_id=<?php echo $post['EkIdUser']; ?>"><?php echo $post['username'] ?></a></h2>
    </header>
    <figure>
        <?php 
            echo '<img src='.get_user_post_path($post['EkIdUser'], $post['imgPost']).' alt="" />';
            echo "<figcaption>".$post['caption']."</figcaption>";
        ?>
    </figure>
    <footer>
        <form action="#" method="POST">
            <ul> 
                <li><label for="like" hidden>Like:</label><input id="like" type="image" src="<?php echo ICON_HEART_EMPTY; ?>" alt="Like"/></li>
            </ul>
        </form>
        <form action="#" method="GET">
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