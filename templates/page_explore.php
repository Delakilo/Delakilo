<!-- Alessandro Verna -->
<section>
    <form action="" method="GET">
        <ul>
            <li><label for="search_bar" hidden></label><input id="search_bar" type="text" name="search" autocomplete="on" placeholder="Search"/></li>
            <li><label for="search_btn" hidden></label><input id="search_btn" type="submit" value="Search"/></li>
        </ul>
    </form>
</section>
<?php
    $posts = $db->postsGetAll();
    require('templates/posts.php');
?>