<?php
session_start();
require '../assets/database/conn.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = strip_tags(trim($_POST['first_name'] ?? ''));
    $last_name  = strip_tags(trim($_POST['last_name'] ?? ''));
    $username = strip_tags(trim($_POST['username'] ?? ''));
    $email      = strip_tags(trim($_POST['email'] ?? ''));
    $password   = $_POST['password'] ?? '';
    $password2  = $_POST['password2'] ?? '';
    $lstgm      = strip_tags(trim($_POST['lstgm'] ?? ''));

    $errors = [];
    $full_name = $first_name . ' ' . $last_name;

    //Validations
    if(strlen($first_name) < 2){
        $errors[] = "Numele trebuie să aibă cel puțin 2 caractere.";
    }
    if(strlen($last_name) < 2){
        $errors[] = "Prenumele trebuie să aibă cel puțin 2 caractere.";
    }
    if(strlen($username) < 4){
        $errors[] = "Username-ul trebuie să aibă cel puțin 4 caractere.";
    }
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors[] = "Adresa de email nu este validă.";
    }
    if($password !== $password2){
        $errors[] = "Parolele nu se potrivesc.";
    }


    $stmt = $conn->prepare('SELECT account_ID FROM accounts WHERE email = ? OR username = ? OR cod_liga = ?');
    $stmt->bind_param('sss', $email, $username, $lstgm);
    $stmt->execute();
    $result=$stmt->get_result();

    if ($result->num_rows !== 0) {
        $errors[] = "Email-ul, username-ul sau codul de liga există deja.";
    }
    if(!empty($errors)){
        $_SESSION['register_errors'] = $errors;
        header('Location: ../register-page.php');
        exit();
    }


    $pass_hash = password_hash($password,PASSWORD_DEFAULT);
    $stmt = $conn->prepare('INSERT INTO accounts (full_name, username, email, cod_liga, role, is_active, password) VALUES (?,?,?,?,"user",0,?)');
    $stmt->bind_param('sssss', $full_name, $username, $email, $lstgm, $pass_hash);
    $stmt->execute();
    $_SESSION['success'] = "Cont creat! Așteaptă aprobarea administratorului.";
    header('Location: ../index.php');
    exit;
}
