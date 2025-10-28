<?php
include '../assets/database/conn.php';
$query = "SELECT * from accounts";
$result = $conn->query($query);

$accounts = [];

while ($row = $result->fetch_assoc()) {
    $accounts[] = [
        'account_id' => $row['account_ID'],
        'full_name' => $row['full_name'],
        'username' => $row['username'],
        'email' => $row['email'],
        'cod_liga' => $row['cod_liga'],
        'role' => $row['role'],
        'is_active' => $row['is_active']
    ];
}
echo json_encode($accounts);
$conn->close();
