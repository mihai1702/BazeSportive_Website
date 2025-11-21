
<?php
    session_start();
    require 'assets/database/conn.php';
    $user_id=$_SESSION['user_id'];

    $stmt = $conn->prepare('SELECT reservation_id, date, start_time, end_time, nr_participants FROM reservations WHERE account_id = ? ORDER BY date, start_time');
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style/style.css">
    
    <title>My Reservations</title>
</head>
<body>
    <?php 
        include 'assets/components/loading-screen.php';
        include 'assets/components/header.php';
    ?>
    <table class="table-section">
        <thead>
            <tr>
                <th>Data</th>
                <th>Ora start</th>
                <th>Ora final</th>
                <th>Nr. Persoane</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr data-row-id="<?= $row['reservation_id'] ?>">
                <th> <?= htmlspecialchars($row['date']) ?> </th>
                <th><?= date('H:i', strtotime($row['start_time'])) ?></th>
                <th><?= date('H:i', strtotime($row['end_time'])) ?></th>
                <th><?= htmlspecialchars($row['nr_participants'])?></th>
                <th>
                    <button class="btn btn-cancel-res" data-id="<?= $row['reservation_id']?>">Anuleaza</button>
                </th>
            </tr>
            <?php endwhile;?>
        </tbody>
        
    </table>
<?php include 'assets/components/footer.php';?>
<script src="assets/js/script.js"></script>
</body>
</html>