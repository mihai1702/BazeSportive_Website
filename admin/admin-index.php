<?php
    require '../authentification/admin_auth_check.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" href="../assets/style/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</head>
<body>
    <?php include '../assets/components/header.php' ?>
    <section class="table-section">
        <div>
            <div class="table-header">
                <h1>Administrative page</h1>
                <a id="btn-reservations" class="btn btn-primary active">Reservations</a>
                <a id="btn-accounts" class="btn btn-primary">Accounts</a>
            </div>

            <table id="reservations-table" class="table table-hover active">
                <thead>
                    <tr>
                        <th>Reservation ID</th>
                        <th>Date</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Client name</th>
                        <th>Nr of Participants</th>
                        
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
            <table id="accounts-table" class="table table-hover">
                <thead>
                    <tr>
                        <th>Account ID</th>
                        <th>Full Name</th>
                        <th>username</th>
                        <th>email</th>
                        <th>Cod Liga</th>
                        <th>role</th>
                        <th>is Active?</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="admin-scripts/admin-script.js"></script>
</body>
</html>