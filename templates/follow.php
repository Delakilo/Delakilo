<!-- TODO: usare l'id vero dello user cliccato + decidere quando invece usare userGetFollowers($user_id) -->
<?php foreach($db->userGetFollowing(1) as $follow): ?>
<article>
    <ol>
        <li>
            <img src="<?php echo IMG_DEFAULT_PROFILE; ?>" alt=""/>
            <h2><a href="./home_profile.php"><?php echo $follow['username'] ?></a></h2>
        </li>
    </ol>
</article>
<?php endforeach; ?>