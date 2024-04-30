<!-- Alessandro Verna -->
<section>
    <form action="exploresearch.php" method="GET">
        <ul>
            <li><label for="search_bar" hidden></label><input id="search_bar" type="text" name="SearchBar" autocomplete="on" placeholder="Search"/></li>
            <li><label for="search_btn" hidden></label><input id="search_btn" type="submit" value="Search"/></li>
        </ul>
    </form>
</section>
<article>
    <ol>
        <?php foreach($db->usersGetByBaseName($_GET['SearchBar']) as $username): ?>
        <li>
            <img src="<?php echo IMG_DEFAULT_PROFILE; ?>" alt="profile"/>
            <h2><a href="./exploreprofile.php?user_id=<?php echo $username['IdUser']; ?>"><?php echo $username['username']; ?></a></h2>
        </li>
        <?php endforeach; ?>
    </ol>
</article>
