<?php
// Start the session
session_start();

// Check if the user is not logged in, redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login_page.php");
    exit();
}

if (isset($_GET['logout']) && $_GET['logout'] == 1) {
    // Unset all session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect to login page after logout
    header("Location: View/login_page.php");

    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Money Transfer (Satna)</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/transferPagesStyles.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark">
    <a class="navbar-brand" href="#">Dashboard</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
                <a class="nav-link" href="../dashboard.php">Dashboard </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Profile</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?logout=1">Logout</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container">
    <h2>Money Transfer (Satna)</h2>
    
    <form action="../Controller/process_transfer_Satna.php" method="post">
        <div class="form-group col-md-6">
            <label for="senderCard">Choose One of Your Cards:</label>
            <select class="form-control" id="senderCard" name="senderCard" required>
                <?php

                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "bank";

                $conn = new mysqli($servername, $username, $password, $dbname);
                $username = $_SESSION['username'];
                $userCardsQuery = "SELECT iban FROM accounts WHERE user_id = (SELECT id FROM users WHERE username = '$username')";
                $userCardsResult = $conn->query($userCardsQuery);

                // Check if there was an error with the query
                if (!$userCardsResult) {
                    echo "Error: " . $conn->error;
                } else {
                    // Loop through the results and create options for the dropdown
                    while ($row = $userCardsResult->fetch_assoc()) {
                        $IBAN = $row['iban'];
                        echo "<option value=\"$IBAN\">$IBAN</option>";
                    }
                }
                ?>
            </select>
        </div>

        <div class="form-group col-md-6">
            <label for="receiverIBAN">Receiver Card No:</label>
            <input type="text" class="form-control" id="receiverIBAN" name="receiverIBAN" required>
        </div>
        <div class="form-group col-md-6">
            <label for="amount">Amount:</label>
            <input type="number" class="form-control" id="amount" name="amount" required>
        </div>
        <div class="form-group col-md-6">
            <button type="submit" class="btn btn-primary">Transfer Money</button>
        </div>
    </form>
    
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
