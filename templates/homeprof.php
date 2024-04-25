<!-- Francesco Filippini -->
<section>
    <h2>User2</h2>
    <div>
        <img src="<?php echo IMG_DEFAULT_PROFILE; ?>" alt=""/>
        <ul>
            <li><em>XX<br/>Posts</em></li><li><a href=""><em>XX<br/>Followers</em></a></li><li><a href=""><em>XX<br/>Following</em></a></li>
        </ul>
    </div>
    <p><strong>Name Surname</strong></p>
    <p><small>Bio...</small></p>
    <footer>
        <p><a href="">Follow</a></p>
    </footer>
</section>
<article>
    <!-- TODO: Warning: article lacks heading  -->
    <figure>
        <img src="../img/posts/post3.jpg" alt=""/>
        <figcaption>Check out this photo I posted!</figcaption>
    </figure>
    <footer>
        <form action="#" method="POST">
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