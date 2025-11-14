<!doctype html>
<html lang="ro">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Logare - UMFST Booking</title>
<link rel="stylesheet" href="assets/style/auth-style.css">
<link rel="stylesheet" href="assets/style/style.css">
</head>
<body>
  <?php include 'assets/components/loading-screen.php'; ?>
  <?php include 'assets/components/header.php' ?>
<div class="card">
<h2>Logare</h2>

<?php 
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }; 
    if (!empty($_SESSION['errors'])): ?>
  <div class="error-box">
    <p><?= $_SESSION['errors']?></p>
  </div>
  <?php unset($_SESSION['errors']); ?>
    <?php endif; ?>


<form method="post" action="authentification/login.php">
  <div class="input-group">
    <label>Email</label>
    <input id="email" name="email" type="email" required value="<?=htmlspecialchars($_POST['email']??'')?>">
  </div>
  <div class="input-group">
    <label>Parolă</label>
    <input id="password" name="password" type="password" required>
    <div>
      <button type="button" class="pw-toggle" data-target="password">Arată parola</button>
    </div>
  </div>
  <button type="submit" class="btn-primary">Logare</button>
  <a href="register-page.php"><button type="button" class="btn-secondary">Creează cont</button></a>
  <div class="small">După logare veți fi direcționat în zona de programări (dacă contul este aprobat).</div>
</form>



<script src="assets/js/auth-script.js"></script>
</div>
</body>
</html>
