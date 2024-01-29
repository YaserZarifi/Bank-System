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
    header("Location: login_page.php");

    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bank";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from the form
    $transactionCode = $_POST['transactionCode'];


    // Perform the query to fetch transaction details
    $query = "SELECT * FROM transactions WHERE tracking_code = '$transactionCode'";
    $result = $conn->query($query);

    // Check if the query was successful
    if ($result) {
        // Check if any rows were returned
        if ($result->num_rows > 0) {
            // Fetch the results as an associative array
            $transactionDetails = $result->fetch_all(MYSQLI_ASSOC);
        } else {
            $errorMessage = "Transaction not found with the provided code.";
        }
    } else {
        $errorMessage = "Error: " . $query . "<br>" . $conn->error;
    }
}

function displayTransactionDetails($details) {
    echo "<h3>Transaction Details:</h3>";
    echo "<table class='table'>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Source Account</th>
                    <th>Destination Account</th>
                    <th>Amount</th>
                    <th>Transaction Type</th>
                    <th>Timestamp</th>
                    <th>Tracking Code</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>";

    foreach ($details as $transaction) {
        echo "<tr>
                <td>{$transaction['id']}</td>
                <td>{$transaction['source_account']}</td>
                <td>{$transaction['destination_account']}</td>
                <td>{$transaction['amount']}</td>
                <td>{$transaction['transaction_type']}</td>
                <td>{$transaction['timestamp']}</td>
                <td>{$transaction['tracking_code']}</td>
                <td>{$transaction['status']}</td>
            </tr>";
    }

    echo "</tbody>
        </table>";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Check Transaction</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/checkTransactionStyles.css">

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
    <h2>Check Transaction</h2>

    <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label for="transactionCode">Transaction Code:</label>
            <input type="text" class="form-control" id="transactionCode" name="transactionCode" required>
        </div>
        <button type="submit" class="btn btn-primary">Check Transaction</button>
    </form>

    <?php
    // Display the transaction details or error message
    if (isset($transactionDetails)) {
        displayTransactionDetails($transactionDetails);
    } elseif (isset($errorMessage)) {
        echo "<br>";
        echo "<p>{$errorMessage}</p>";
    }
    ?>
    
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
