<!-- TODO: usare l'id vero dello user cliccato + decidere quando invece usare userGetFollowers($user_id) -->
<?php foreach($db->userGetFollowing(1) as $follow): ?>
<article>
    <ol>
        <li>
            <img src="<?php echo IMG_DEFAULT_PROFILE; ?>" alt=""/>
            <h2><a href="./homeprofile.php?user_id=<?php echo $follow["IdUser"]; ?>"><?php echo $follow["username"] ?></a></h2>
            <!-- da sistemare $follow["IdUser"] mettendo quello che uso a riga 1 per mettere l'id ovvero templateParams["user_id"] -->
        </li>
    </ol>
</article>
<?php endforeach; ?>