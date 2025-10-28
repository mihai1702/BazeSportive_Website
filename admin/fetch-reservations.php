<?php
include '../assets/database/conn.php';
$query = "SELECT r.*, a.full_name AS client_name from reservations r JOIN accounts a ON r.account_id = a.account_ID";
$result = $conn->query($query);
$reservations = [];
while ($row = $result->fetch_assoc()) {
    $reservations[] = [
        'reservation_id' => $row['reservation_id'],
        'date' => $row['date'],
        'start_time' => $row['start_time'],
        'end_time' => $row['end_time'],
        'account_id' => $row['account_id'],
        'client_name' => $row['client_name'],
        'nr_participants' => $row['nr_participants'],
        'delete_token' => $row['delete_token']
    ];
}
echo json_encode($reservations);
$conn->close();