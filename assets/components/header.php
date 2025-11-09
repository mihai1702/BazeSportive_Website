<?php
    if(session_status()===PHP_SESSION_NONE){
        session_start();
    }
?>

<header>
        <a href="/BazeSportive_website/index.php">Home</a>
        <?php if(!isset($_SESSION['user_id'])): ?>
            <a href="login-page.php">Login</a>
            <a href="register-page.php">Register</a>
        <?php elseif(isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <a href="/BazeSportive_website/admin/admin-index.php">Admin Panel</a>
            <a href="/BazeSportive_website/authentification/logout.php">Logout</a>
        <?php else: ?>
            <a href="reservation-page.php">Reservations</a>
            <a href="/BazeSportive_website/authentification/logout.php">Logout</a>
        <?php endif; ?>
</header>