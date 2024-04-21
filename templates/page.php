<!-- Alessandro Verna -->
<header>
    <h1>Delakilo</h1>
</header>
<nav>
    <ul><li id="home"><a href="home.html"><img src="../img/menu/home.svg" alt="home"/><span class="menu-text">Home</span></a></li><li id="explore"><a href="exploreposts.html"><img src="../img/menu/search.svg" alt="explore"/><span class="menu-text">Explore</span></a></li><li id="notifications"><a href="notifications.html"><img src="../img/menu/bell.svg" alt="notifications"/><span class="menu-text">Notifications</span></a></li><li id="profile"><a href="myprofile.html"><img src="../img/menu/user.svg" alt="profile"/><span class="menu-text">Profile</span></a></li></ul>
</nav>
<?php
    if (isset($templateParams['subpage'])) {
        require($templateParams['subpage']);
    } else {
        die('Unspecified PHP page in main tag');
    }
?>