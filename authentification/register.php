<?php
require '../assets/database/conn.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name  = trim($_POST['last_name'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $email      = trim($_POST['email'] ?? '');
    $password   = $_POST['password'] ?? '';
    $password2  = $_POST['password2'] ?? '';
    $lstgm      = trim($_POST['lstgm'] ?? '');

    $full_name = $first_name . ' ' . $last_name;

    $stmt = $conn->prepare('SELECT account_ID FROM accounts WHERE email = ?');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result=$stmt->get_result();
    if ($result->num_rows===0){
      $pass_hash = password_hash($password,PASSWORD_DEFAULT);
      $stmt = $conn->prepare('INSERT INTO accounts (full_name, username, email, cod_liga, role, is_active, password) VALUES (?,?,?,?,"user",0,?)');
      $stmt->bind_param('sssss', $full_name, $username, $email, $lstgm, $pass_hash);
      $stmt->execute();
      $conn->close();
      header('Location: ../index.php');
    }
}
