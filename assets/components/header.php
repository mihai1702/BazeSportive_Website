<?php
    if(session_status()===PHP_SESSION_NONE){
        session_start();
    }
?>

<header>
    <img src="https://umfst.ro/wp-content/uploads/2023/01/new-logo-UMFST-bigger-mark.svg" alt=".">
    <h1>BAZA SPORTIVA</h1>

    <a class="menu-toggle" id="menuToggle" href=""><img class="menu-toggle" src="assets/icons/navbar-icon.svg" alt="navbar-icon"></a>

    <div class="navbar">
        <a href="/BazeSportive_website/index.php">Acasa</a>
        <?php if(!isset($_SESSION['user_id'])): ?>
            <a href="login-page.php">Login</a>
            <a href="register-page.php">Register</a>
        <?php elseif(isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <a href="/BazeSportive_website/admin/admin-index.php">Admin Panel</a>
            <a href="/BazeSportive_website/authentification/logout.php">Logout</a>
        <?php else: ?>
            <a href="reservation-page.php">Program</a>
            <a href="my-reservations-page.php">Rezervarile mele</a>
            <a href="/BazeSportive_website/authentification/logout.php">Logout</a>
        <?php endif; ?>
    </div>
</header>