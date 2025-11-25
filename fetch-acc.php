<?php
require 'assets/database/conn.php';

$query = "SELECT account_ID, full_name FROM accounts WHERE is_active = 1 AND role = 'user' ORDER BY full_name";

$result = $conn->query($query);

$accounts = [];
while($row = $result->fetch_assoc()){
    $accounts[] = [
        'account_id' => $row['account_ID'],
        'full_name' => $row['full_name']
    ];
}
echo json_encode($accounts);
$conn->close();