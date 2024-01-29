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

// Define minimum initial amount
$minInitialAmount = 100000; // Set your minimum amount here
$accountCountLimitation = 3;

// Initialize the error message variable
$errorMsg = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from the form
    $initialBalance = $_POST['initialAmount'];

    // Validate the initial amount
    if ($initialBalance < $minInitialAmount) {
        $errorMsg = "Initial amount must be at least $minInitialAmount.";
    } else {
        // Check if the user has already created a bank account
        $userId = $_SESSION['user_id'];
        $checkAccountQuery = "SELECT COUNT(*) as account_count FROM accounts WHERE user_id = '$userId'";
        $checkAccountResult = $conn->query($checkAccountQuery);

        $accountCount = $checkAccountResult->fetch_assoc()['account_count'];
        if ($accountCount >= $accountCountLimitation) {
            // User has already created an account
            $errorMsg = "You can only create $accountCountLimitation bank account.";
        } else {
            // Generate unique card number and IBAN
            $cardNumber = generateCardNumber();
            $iban = generateIBAN();

            // Insert data into the accounts table
            $insertAccountQuery = "INSERT INTO accounts (user_id, card_number, iban, balance) VALUES ('$userId', '$cardNumber', '$iban', '$initialBalance')";

            if ($conn->query($insertAccountQuery) === TRUE) {
                // Retrieve the newly created account details
                $row = getAccountDetails($conn, $userId);
            } else {
                $errorMsg = "Error: " . $insertAccountQuery . "<br>" . $conn->error;
            }
        }
    }
}

function generateCardNumber() {
    return '4' . str_pad(mt_rand(1000, 9999), 16, '0', STR_PAD_LEFT);
}

function generateIBAN() {
    return 'IBAN' . mt_rand(1000000000, 9999999999);
}

function getAccountDetails($conn, $userId) {
    $selectAccountQuery = "SELECT a.*, u.name, u.last_name, u.username FROM accounts a
                          JOIN users u ON a.user_id = u.id
                          WHERE a.user_id = '$userId'
                          ORDER BY a.id DESC LIMIT 1";
    $result = $conn->query($selectAccountQuery);

    return $result->fetch_assoc();
}


$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Create Bank Account</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/createBankAccountStyles.css">

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
    <h2>Create Bank Account</h2>

    <?php if (isset($_SESSION['user_id'])): ?>
        <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="initialAmount">Initial Amount:</label>
                <input type="number" class="form-control" id="initialAmount" name="initialAmount" required>
                <?php if ($errorMsg): ?>
                    <div class="alert alert-danger mt-2"><?= $errorMsg; ?></div>
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary">Create Account</button>
        </form>

        <?php if (isset($row)): ?>
            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="card-title">Account Details:</h5>
                    <p class="card-text"><strong>Card Number:</strong> <?= $row['card_number']; ?></p>
                    <p class="card-text"><strong>IBAN:</strong> <?= $row['iban']; ?></p>
                    <p class="card-text"><strong>Name:</strong> <?= $row['name']; ?></p>
                    <p class="card-text"><strong>Username:</strong> <?= $row['username']; ?></p>
                    <button class="btn btn-success" onclick="generateCard()">Generate Card</button>
                </div>
            </div>
        <?php endif; ?>

    <?php else: ?>
        <p>User not logged in</p>
    <?php endif; ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
