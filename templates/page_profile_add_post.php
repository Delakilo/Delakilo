<section>
    <form action="submits/add_post.php" method="POST" enctype="multipart/form-data">
        <h2>Add post</h2>
        <ul>
            <li><label for="image">Image:</label><input id="image" type="file" name="image" accept=".jpg,.jpeg,.png" required/></li>
            <li><label for="caption">Caption:</label><textarea id="caption" name="caption" placeholder="Caption" maxlength="1000"></textarea></li>
            <?php
                if (isset($templateParams['error'])) {
                    echo '<li><p>'.$templateParams['error'].'</p></li>';
                }
            ?>
            <li><label for="post" hidden>Post:</label><input id="post" type="submit" value="Post"/></li>
        </ul>
    </form>
</section>
