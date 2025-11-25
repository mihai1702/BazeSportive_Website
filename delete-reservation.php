<?php 
session_start();
require 'assets/database/conn.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status'=>'error', 'message'=>'Trebuie să fii logat.']);
    exit;
}

if (!isset($_POST['reservation_id'])) {
    echo json_encode(['status'=>'error', 'message'=>'ID lipsă.']);
    exit;
}

$res_id = intval($_POST['reservation_id']);
$user_id=$_SESSION['user_id'];

$stmt2 = $conn->prepare("DELETE FROM participants_of_reservations WHERE reservation_id = ?");
$stmt2-> bind_param("i", $res_id);

if($stmt2->execute()){
    $stmt = $conn->prepare("DELETE FROM reservations WHERE reservation_id = ? AND account_id = ?");
    $stmt->bind_param("ii", $res_id, $user_id);
    if ($stmt->execute()) {
        echo json_encode(['status'=>'success', 'message'=>'Rezervare anulată cu succes.']);
    } else {
        echo json_encode(['status'=>'error', 'message'=>'Eroare la anulare.']);
    }
}
else{
    echo json_encode(['status'=>'error', 'message'=>'Eroare la stergerea participantilor']);
}

