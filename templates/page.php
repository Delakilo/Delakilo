<div id="main_bar">
    <!-- <header>
        <h1 hidden>Delakilo</h1>
        <p><a href="./logout.php">Logout</a></p>
    </header> -->
    <nav class="general_menu">
        <ul>
            <li><a href="./logout.php">Logout</a></li>
        </ul>
    </nav>
    <nav class="page_menu">
        <ul>
            <li id="home"><a href="home.php"><img src="<?php echo ICON_HOME; ?>" alt="home"/><span class="menu-text">Home</span></a></li><li id="explore"><a href="explore.php"><img src="<?php echo ICON_SEARCH; ?>" alt="explore"/><span class="menu-text">Explore</span></a></li><li id="notifications"><a href="notifications.php"><img src="<?php echo ICON_BELL; ?>" alt="notifications"/><span class="menu-text">Notifications</span></a></li><li id="profile"><a href="profile.php"><img src="<?php echo ICON_USER; ?>" alt="profile"/><span class="menu-text">Profile</span></a></li>
        </ul>
    </nav>
</div>
<main>
    <?php
        if (isset($templateParams['subpage'])) {
            require($templateParams['subpage']);
        } else {
            die('Unspecified PHP page in main tag');
        }
    ?>
</main>