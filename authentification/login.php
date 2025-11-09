<?php
require '../assets/database/conn.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if($_SERVER['REQUEST_METHOD']==='POST'){
    $email=$_POST['email']??'';
    $password=$_POST['password']??'';

    
        $stmt=$conn->prepare('SELECT account_ID, password, is_active,full_name, role FROM accounts WHERE email=?');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result=$stmt->get_result();
        
        if($result->num_rows===0){
            $user=null;
        } else {
            $user=$result->fetch_assoc();

            if (!$user) {
                $_SESSION['errors'] = 'Email sau parolă greșită.';
                header('Location: ../login-page.php');
                exit;
            }

            if (!password_verify($password, $user['password'])) {
                $_SESSION['errors'] = 'Email sau parolă greșită.';
                header('Location: ../login-page.php');
                exit;
            }
            else if((int)$user['is_active']===0){
              $_SESSION['errors']='Contul nu a fost aprobat.';
              header('Location: ../login-page.php');
            }
            else {
            session_regenerate_id(true);
            $_SESSION['user_id']=$user['account_ID'];
            $_SESSION['user_name']=$user['full_name'];
            $_SESSION['user_email']=$email;
            $_SESSION['role']=$user['role'];
            if($user['role']==='admin'){
                header('Location: ../admin/admin-index.php');
                exit;
            }
            else{
            header('Location: ../reservation-page.php');
            exit;
            }
        }

      }

  }