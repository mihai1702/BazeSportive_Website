<?php 
session_start();
if (!empty($_SESSION['success'])): ?>
    <div class="success-box">
      <p>Contul a fost creat cu succes! </p>
      <p>Asteapta confirmarea administratorului inainte de logare</p>
    </div>
<?php 
unset($_SESSION['success']);
endif; 
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Baze Sportive UMFST – Rezervări</title>

    <link rel="icon" href="/bazesportive_website/assets/icons/logo-icon.png">
    <link rel="stylesheet" href="assets/style/style.css">
</head>
<body>
    <?php
        include 'assets/components/loading-screen.php';
        include 'assets/components/header.php';
    ?>
    <main class="home-wrapper">

        <!-- Hero section -->
        <section class="hero">
            <div class="hero-text">
                <h1>Baze Sportive UMFST – Rezervări Online</h1>
                <p>Rezervă rapid terenurile UMFST G. E. Palade – simplu, modern și accesibil tuturor studenților și cadrelor universitare.</p>
                <a href="login-page.php" class="hero-btn">Începe acum</a>
            </div>
        </section>

        <!-- Functionalități -->
        <section class="features">
            <h2>Ce poți face pe platformă?</h2>

            <div class="feature-list">
                <div class="feature-item">
                    <img src="assets/icons/calendar-icon.gif" alt="...">
                    <h3>Vezi programul</h3>
                    <p>Vizualizezi calendarul și orele disponibile în timp real.</p>
                </div>

                <div class="feature-item">
                    <img src="assets/icons/hourglass-icon.gif">
                    <h3>Rezervări rapide</h3>
                    <p>Rezervi terenul cu doar câteva click-uri.</p>
                </div>

                <div class="feature-item">
                    <img src="assets/icons/team-icon.gif">
                    <h3>Selectezi participanți</h3>
                    <p>Alegi colegii sau prietenii care vin cu tine.</p>
                </div>

                <div class="feature-item">
                    <img src="assets/icons/modify-icon.gif">
                    <h3>Gestionezi rezervările</h3>
                    <p>Modifici sau anulezi rezervările tale simplu și rapid.</p>
                </div>
            </div>
        </section>

    </main>

    <?php
        include 'assets/components/footer.php';
    ?>
</body>
<script src="assets/js/script.js"></script>
</body>
</html>