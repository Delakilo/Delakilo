<article>
    <ol>
        <?php foreach($users as $user): ?>
        <li>
            <img src="<?php echo get_user_profile($user['IdUser'], $user['userImageName']); ?>" alt=""/>
            <h2><a href="<?php echo $_SERVER['PHP_SELF']; ?>?user_id=<?php echo $user["IdUser"]; ?>"><?php echo $user["username"] ?></a></h2>
        </li>
        <?php endforeach; ?>
    </ol>
</article>
