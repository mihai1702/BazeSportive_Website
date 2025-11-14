<?php
session_start();
require 'assets/database/conn.php';

if(!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    echo json_encode(['status' => 'error', 'message' => 'Trebuie să fii logat pentru a face o rezervare.']);
    exit;
}

if (
    !isset($_POST['start_time']) ||
    !isset($_POST['duration']) ||
    !isset($_POST['nr_participants'])
) {
    echo json_encode(['status' => 'error', 'message' => 'Date incomplete.']);
    exit;
}

$account_id = $_SESSION['user_id'];
$start_time = $_POST['start_time'];
$duration = intval($_POST['duration']);
$nr_participants = intval($_POST['nr_participants']);

$start_timestamp = strtotime($start_time);
$end_timestamp = $start_timestamp + ($duration * 60);
$end_time = date('Y-m-d H:i:s', $end_timestamp);
$start_time_formatted = date('Y-m-d H:i:s', $start_timestamp);

$delete_token = bin2hex(random_bytes(8));


$stmt = $conn->prepare("INSERT INTO reservations (date, start_time, end_time, account_id, nr_participants, delete_token) VALUES (?, ?, ?, ?, ?, ?)");
$date = date('Y-m-d', $start_timestamp);
$start_hour = date('H:i:s', $start_timestamp);
$end_hour = date('H:i:s', $end_timestamp);

$stmt->bind_param("sssiis", $date, $start_hour, $end_hour, $account_id, $nr_participants, $delete_token);

if($stmt->execute()){
    echo json_encode(['status' => 'success', 'message' => 'Rezervarea a fost realizată cu succes.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Eroare la realizarea rezervării. Te rugăm să încerci din nou.']);
}
$conn->close();