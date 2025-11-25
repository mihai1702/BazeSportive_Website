<?php
session_start();
require 'assets/database/conn.php';

header('Content-Type: application/json'); // IMPORTANT – trimite doar JSON

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Trebuie să fii logat pentru a face o rezervare.']);
    exit;
}

if (
    empty($_POST['start_time']) ||
    empty($_POST['duration']) ||
    !isset($_POST['participants'])
) {
    echo json_encode(['status' => 'error', 'message' => 'Date incomplete.']);
    exit;
}

$account_id = $_SESSION['user_id'];
$start_time = $_POST['start_time'];
$duration = intval($_POST['duration']);
$participants = $_POST['participants']; // array
$nr_participants = count($participants);

$start_ts = strtotime($start_time);
$end_ts = $start_ts + ($duration * 60);

$date = date('Y-m-d', $start_ts);
$start_h = date('H:i:s', $start_ts);
$end_h = date('H:i:s', $end_ts);

$delete_token = bin2hex(random_bytes(8));

$conn->begin_transaction();

try {
    // 1️⃣ Inserăm rezervarea
    $stmt = $conn->prepare("
        INSERT INTO reservations (date, start_time, end_time, account_id, nr_participants, delete_token)
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("sssiss", $date, $start_h, $end_h, $account_id, $nr_participants, $delete_token);
    $stmt->execute();

    $reservation_id = $stmt->insert_id;

    // 2️⃣ Inserăm participanții
    $stmt2 = $conn->prepare("
        INSERT INTO participants_of_reservations (reservation_id, participant_id)
        VALUES (?, ?)
    ");

    foreach ($participants as $pid) {
        $stmt2->bind_param("ii", $reservation_id, $pid);
        $stmt2->execute();
    }

    $conn->commit();

    echo json_encode(['status' => 'success', 'message' => 'Rezervarea a fost realizată cu succes.']);
} 
catch (Exception $e) {
    $conn->rollback();
    echo json_encode(['status' => 'error', 'message' => 'Eroare la salvare: ' . $e->getMessage()]);
}

$conn->close();
