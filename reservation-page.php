<?php
    require 'authentification/auth_guard.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation page</title>
    <link rel="stylesheet" href="assets/style/style.css">
    <script src="assets/calendar/index.global.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'assets/components/loading-screen.php'; ?>
    <?php include 'assets/components/header.php' ?>
    <main>
    <div class="reservation-page-body">
        <div>
            <h1>Program fotbal universitate</h1>
            <p>Selecteaza data dorita pe calendar pentru a face o rezervare</p>
        </div>
    
        <div id="calendar"></div>

    </div>
    </main>
    <?php include 'assets/components/footer.php';?>
    <script src="assets/js/script.js"></script>
</body>
</html>