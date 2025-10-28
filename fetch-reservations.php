<?php
include 'assets/database/conn.php';

$query = "SELECT * from reservations";
$result = $conn->query($query);
$reservations = [];

while ($row = $result->fetch_assoc()) {
    $reservations[] = [
        'title' => 'Rezervare (' . $row['nr_participants'] . ' pers.)',
        'start' =>$row['date'] . 'T' . $row['start_time'],
        'end' => $row['date'] . 'T' . $row['end_time'],
    ];
}   
echo json_encode($reservations);
$conn->close(); 