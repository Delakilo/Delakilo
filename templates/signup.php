<nav>
    <ul><li id="signin"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?page=signin">Sign in</a></li><li id="signup">Sign up</li></ul>
</nav>
<header>
    <h1>Delakilo</h1>
</header>
<main>
    <img src="<?php echo ICON_LOGO; ?>" alt=""/>
    <form action="" method="POST" onsubmit="submitForm2Data()">
        <h2>Register</h2>
        <ul>
            <li>
                <label for="username">Username:</label>
                <input id="username" type="text" name="username" placeholder="Username" pattern="^[a-zA-Z][a-zA-Z0-9._\-]*$" title="the first character must be a letter, other characters are allowed also numbers and [._-] special characters, spaces are not allowed" minlength="2" maxlength="50" required/></li>
            <li>
                <label for="pwd1">Password:</label>
                <input id="pwd1" type="password" name="pwd1" placeholder="Password" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]+$" title="it has to contain at least one lowercase letter, it has to contain at least one uppercase letter, it has to contain at least one digit, it has to contain at least one special character from the set [!@#$%^&*]" minlength="10" maxlength="100" required/></li>
            <li>
                <label for="pwd2">Confirm Password:</label>
                <input id="pwd2" type="password" name="pwd2" placeholder="Password" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]+$" title="it has to contain at least one lowercase letter, it has to contain at least one uppercase letter, it has to contain at least one digit, it has to contain at least one special character from the set [!@#$%^&*]" minlength="10" maxlength="100" required/></li>
            <?php
                if (isset($templateParams['error'])) {
                    echo '<li><p>'.$templateParams['error'].'</p></li>';
                }
            ?>
            <li><label for="register" hidden>Register:</label><input id="register" type="submit" value="Register" onclick="return validatePasswords()"/></li>
        </ul>
    </form>
</main>
<footer>
    <p>©Delakilo</p>
</footer>
