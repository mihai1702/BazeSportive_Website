<!doctype html>
<html lang="ro">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Creare cont - UMFST Booking</title>
<link rel="stylesheet" href="assets/style/auth-style.css">
<link rel="stylesheet" href="assets/style/style.css">
</head>
<body>
<?php include 'assets/components/loading-screen.php'; ?>
<?php include 'assets/components/header.php' ?>

<div class="card">
<h2>Creare cont</h2>

<!-- errors -->

<form method="post" id="registerForm" action="authentification/register.php" novalidate>
  <div class="input-group"><label>Nume</label><input id="first_name" name="first_name" type="text" required></div>
  <div class="input-group"><label>Prenume</label><input id="last_name" name="last_name" type="text" required></div>
  <div class="input-group"><label>Username</label><input id="username" name="username" type="text" required></div>
  <div class="input-group"><label>Email</label><input id="email" name="email" type="email" required></div>
  <div class="input-group"><label>Număr legitimatie LSTGM</label><input id="lstgm" name="lstgm" type="text" required></div>
  <div class="input-group">
    <label>Parolă</label>
    <input id="password" name="password" type="password" required>
    <div><button type="button" class="pw-toggle" data-target="password">Arată parola</button></div>
    <small class="small">Min 8 caractere, literă mare, literă mică, cifră, caracter special.</small>
  </div>
  <div class="input-group">
    <label>Confirmă parola</label>
    <input id="password2" name="password2" type="password" required>
    <div><button type="button" class="pw-toggle" data-target="password2">Arată parola</button></div>
  </div>

  <!-- errors -->
  <?php if (!empty($_SESSION['register_errors'])): ?>
  <div class="error-box">
    <ul>
      <?php foreach($_SESSION['register_errors'] as $err): ?>
        <li><?= htmlspecialchars($err) ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
  <?php unset($_SESSION['register_errors']); ?>
  <?php endif; ?>

  <button type="submit" class="btn-primary">Creează cont</button>
  <a href="login-page.php"><button type="button" class="btn-secondary">Am deja cont / Logare</button></a>
</form>

<script src="assets/js/auth-script.js"></script>
</div>
</body>
</html>
