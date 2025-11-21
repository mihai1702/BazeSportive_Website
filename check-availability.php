<?php
require 'assets/database/conn.php';

if (!isset($_GET['date']) || !isset($_GET['start'])) {
    echo json_encode(['error' => 'Parametri lipsă']);
    exit;
}

$date = $_GET['date'];
$start = $_GET['start'];

$weekday = date('w', strtotime($date));

if ($weekday == 1) {
    $program_end = "21:30:00";
} 
else if ($weekday == 5) {
    $program_end = "21:00:00";
}else {
        echo json_encode(['error' => 'programul e doar luni si vineri']);
        return;
      }

$stmt = $conn->prepare("
    SELECT start_time
    FROM reservations
    WHERE date = ?
    AND start_time > ?
    ORDER BY start_time ASC
    LIMIT 1
");
$stmt->bind_param("ss", $date, $start);
$stmt->execute();
$result = $stmt->get_result();


if ($row = $result->fetch_assoc()) {
    $limit = $row['start_time'];
} else {
    $limit = $program_end;
}

$startTs = strtotime("$date $start");
$limitTs = strtotime("$date $limit");

$diffMinutes = ($limitTs - $startTs) / 60;

echo json_encode(['max_minutes' => $diffMinutes]);
exit;