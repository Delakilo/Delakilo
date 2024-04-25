<article>
    <header>
        <img src="<?php echo IMG_DEFAULT_PROFILE; ?>" alt=""/>
        <h2><a href="">User 2</a></h2>
    </header>
    <figure>
        <img src="<?php echo 'doc/img/posts/landscape.jpg'; ?>" alt=""/>
        <figcaption>Check out this photo I posted!</figcaption>
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
        <p><small>Liked by n users</small></p>
        <p><a href="">View all comments</a></p>
        <p><small>4 hours ago</small></p>
    </aside>
</article>
