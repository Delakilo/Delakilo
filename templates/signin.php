<!-- Enrico Marchionni & Francesco Filippini & Alessandro Verna -->
<nav>
    <ul><li id="signin">Sign in</li><li id="signup"><a href="login.php?page=signup">Sign up</a></li></ul>
</nav>
<header>
    <h1>Delakilo</h1>
</header>
<main>
    <img src="<?php echo LOGO; ?>" alt=""/>
    <form action="#" method="POST" onsubmit="submitForm1Data()">
        <h2>Login</h2>
        <ul>
            <li>
                <label for="username">Username:</label>
                <input id="username" type="text" name="username" autocomplete="on" placeholder="Username" pattern="^[a-zA-Z][a-zA-Z0-9._\-]*$" title="the first character must be a letter, other characters are allowed also numbers and [._-] special characters, spaces are not allowed" minlength="2" maxlength="50" required/></li>
            <li>
                <label for="pwd">Password:</label>
                <input id="pwd" type="password" name="pwd" placeholder="Password" minlength="4" maxlength="100" required/></li>
            <?php
                if (isset($templateParams['error'])) {
                    echo '<li><p style="color: red;">'.$templateParams['error'].'</p></li>';
                }
            ?>
            <li><label for="login" hidden>Login:</label><input id="login" type="submit" name="page" value="Login"/></li>
        </ul>
    </form>
</main>
<footer>
    <p>©Delakilo</p>
</footer>
<script type="text/javascript" src="js/sha512.js"></script>
<script type="text/javascript" src="js/login.js"></script>
