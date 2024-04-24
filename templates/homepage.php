<!-- Francesco Filippini -->
<main>
    <article>
        <header>
            <img src="<?php echo DEFAULT_PROFILE; ?>" alt=""/>
            <h2><a href="homeprofile.html">User 2</a></h2>
        </header>
        <figure>
            <img src="<?php echo UPLOAD_DIR_POSTS.'landscape.jpg'; ?>" alt=""/>
            <figcaption>Check out this photo I posted!</figcaption>
        </figure>
        <footer>
            <form action="#" method="POST">
                <ul> 
                    <li><label for="like" hidden>Like:</label><input id="like" type="image" src="<?php echo UPLOAD_LIKECOMMENTADD_UNLIKE; ?>" alt="Like"/></li>
                </ul>
            </form>
            <form action="#" method="GET">
                <ul>
                    <li><label for="comment" hidden>Comment:</label><input id="comment" type="image" src="<?php echo UPLOAD_LIKECOMMENTADD_COMMENT; ?>" alt="Comment"/></li>
                </ul>
            </form>
        </footer>
        <aside>
            <img src="<?php echo DEFAULT_PROFILE; ?>" alt=""/>
            <img src="<?php echo DEFAULT_PROFILE; ?>" alt=""/>
            <img src="<?php echo DEFAULT_PROFILE; ?>" alt=""/>
            <p><small>Liked by n users</small></p>
            <p><a href="comments.html">View all comments</a></p>
            <p><small>4 hours ago</small></p>
        </aside>
    </article>
</main>
