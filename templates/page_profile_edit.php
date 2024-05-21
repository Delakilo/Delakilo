<?php $info = $db->userGetInfoById($templateParams['user_id']); ?>
<section>
    <img src="<?php echo get_user_profile($templateParams['user_id'], $info['userImageName']); ?>" alt=""/>
    <form action="submits/edit_profile.php" method="POST" enctype="multipart/form-data">
        <h2>Edit profile</h2>
        <ul>
            <li><label for="image">Image:</label><input id="image" type="file" name="image" accept=".jpg,.jpeg,.png"/></li>
            <li><label for="username">Username:</label><input id="username" type="text" name="username" placeholder="Username" value="<?php echo htmlspecialchars($info['username'], ENT_QUOTES, 'UTF-8'); ?>" pattern="^[a-zA-Z][a-zA-Z0-9._\-]*$" title="the first character must be a letter, other characters are allowed also numbers and [._-] special characters, spaces are not allowed" minlength="2" maxlength="50" required/></li>
            <li><label for="name">Name:</label><input id="name" type="text" name="name" placeholder="Name" value="<?php echo htmlspecialchars($info['name'], ENT_QUOTES, 'UTF-8'); ?>" maxlength="50"/></li>
            <li><label for="surname">Surname:</label><input id="surname" type="text" name="surname" placeholder="Surname" value="<?php echo htmlspecialchars($info['surname'], ENT_QUOTES, 'UTF-8');; ?>" maxlength="50"/></li>
            <li><label for="bio">Bio:</label><textarea id="bio" name="bio" placeholder="Bio" maxlength="500"><?php echo htmlspecialchars($info['bio'], ENT_QUOTES, 'UTF-8'); ?></textarea></li>
            <?php
                if (isset($templateParams['error'])) {
                    echo '<li><p>'.$templateParams['error'].'</p></li>';
                }
            ?>
            <li><label for="edit" hidden>Edit:</label><input id="edit" type="submit" value="Edit"/></li>
        </ul>
    </form>
</section>
