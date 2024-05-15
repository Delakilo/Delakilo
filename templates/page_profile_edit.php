<?php $info = $db->userGetInfoById($templateParams['user_id']); ?>
<section>
    <img src="<?php echo get_user_profile($templateParams['user_id'], $info['imageURL']); ?>" alt=""/>
    <form action="" method="POST">
        <h2>Edit profile</h2>
        <ul>
            <li><label for="image">Image:</label><input id="image" type="file" name="image"/></li>
            <li><label for="username">Username:</label><input id="username" type="text" name="username" placeholder="Username" value="<?php echo $info['username']; ?>"/></li>
            <li><label for="name">Name:</label><input id="name" type="text" name="name" placeholder="Name" value="<?php echo $info['name']; ?>"/></li>
            <li><label for="surname">Surname:</label><input id="surname" type="text" name="surname" placeholder="Surname" value="<?php echo $info['surname']; ?>"/></li>
            <li><label for="bio">Bio:</label><textarea id="bio" name="bio" placeholder="Bio" value="<?php echo $info['bio']; ?>"></textarea></li>
            <li><label for="edit" hidden>Edit:</label><input id="edit" type="submit" value="Edit"/></li>
        </ul>
    </form>
</section>
