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
    <div id="calendar"></div>

    <script src="assets/js/script.js"></script>
</body>
</html>