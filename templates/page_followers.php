<!-- Francesco Filippini -->
<?php foreach($db->userGetFollowers($templateParams['user_id']) as $follow): ?>
<article>
    <ol>
        <li>
            <img src="<?php echo get_user_profile($follow['IdUser'], $follow['imageURL']); ?>" alt=""/>
            <h2><a href="<?php echo $_SERVER['PHP_SELF']; ?>?user_id=<?php echo $follow["IdUser"]; ?>"><?php echo $follow["username"] ?></a></h2>
        </li>
    </ol>
</article>
<?php endforeach; ?>