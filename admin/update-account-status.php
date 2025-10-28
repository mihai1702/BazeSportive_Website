<?php
include '../assets/database/conn.php';

if(isset($_POST['account_id']) && isset($_POST['is_active'])) {
    $accountId = $_POST['account_id'];
    $isActive = $_POST['is_active'];
    var_dump($accountId, $isActive);
    $stmt = $conn->prepare("UPDATE accounts SET is_active = ? WHERE account_ID = ?");
    $stmt->bind_param("ii", $isActive, $accountId);

    if($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Account status updated successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update account status.']);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid parameters.']);
}