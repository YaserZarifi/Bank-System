<?php
// Start session
session_start();

// Check if the user is not logged in, redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: ../View/login_page.php");
    exit();
}

// Add your database connection code here
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bank";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the sender's username from the session
$senderUsername = $_SESSION['username'];

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $receiverIBAN = $_POST["receiverIBAN"];
    $amount = $_POST["amount"];

    $checkCardQuery = "SELECT * FROM accounts WHERE iban = '$receiverIBAN'";
    $checkCardResult = $conn->query($checkCardQuery);
    $nums = $checkCardResult->num_rows;

    if ($nums === 0) {
        // Receiver IBAN not found in the database
        $status = "FAILED";
    } else {
        // Add logic to check daily transfer limit
        $dailyLimitPaya = 50000000; // 50 million

        // Check if the total transferred today exceeds the daily limit
        $dailyTransfersQuery = "SELECT SUM(amount) AS total FROM daily_transfers WHERE sender_card_no = '$senderUsername' AND transfer_date = CURDATE()";
        $dailyTransfersResult = $conn->query($dailyTransfersQuery);

        $dailyTransfersData = $dailyTransfersResult->fetch_assoc();
        $totalTransferredTodayPaya = $dailyTransfersData['total'];

        if (($totalTransferredTodayPaya + $amount) > $dailyLimitPaya) {
            // Exceeded daily limit
            $status = "FAILED";
            header("Location: transfer_result.php?error=Daily limit exceeded");
            $trackingCode = generateTrackingCode();
            $insertTransactionQuery = "INSERT INTO transactions (source_account, destination_account, amount, transaction_type, tracking_code, status) VALUES (
                (SELECT iban FROM accounts WHERE user_id = (SELECT id FROM users WHERE username = '$senderUsername') LIMIT 1),
                '$receiverIBAN', $amount, 'Paya', '$trackingCode', '$status'
            )";
            $conn->query($insertTransactionQuery);
            exit();
        }

        $balance_query = "SELECT balance FROM accounts WHERE user_id = (SELECT id FROM users WHERE username = '$senderUsername')";
        $result_balance = $conn->query($balance_query);

        $balance_data = $result_balance->fetch_assoc();
        $balance = $balance_data['balance'];

        if ($balance < $amount) {
            // Insufficient balance
            $status = "FAILED";
        } else {
            // Transfer succeeds
            $status = "SUCCESS";

            // Update sender's balance
            $updateSenderBalanceQuery = "UPDATE accounts SET balance = balance - $amount WHERE user_id = (SELECT id FROM users WHERE username = '$senderUsername')";
            $conn->query($updateSenderBalanceQuery);

            // Update receiver's balance
            $updateReceiverBalanceQuery = "UPDATE accounts SET balance = balance + $amount WHERE iban = '$receiverIBAN'";
            $conn->query($updateReceiverBalanceQuery);
        }
    }

    // Insert the transfer record into the transactions table
    $trackingCode = generateTrackingCode();
    $insertTransactionQuery = "INSERT INTO transactions (source_account, destination_account, amount, transaction_type, tracking_code, status) VALUES (
        (SELECT iban FROM accounts WHERE user_id = (SELECT id FROM users WHERE username = '$senderUsername') LIMIT 1),
        '$receiverIBAN', $amount, 'Satna', '$trackingCode', '$status'
    )";
    $conn->query($insertTransactionQuery);

    // Insert the transfer record into the daily_transfers table
    $insertTransferQuery = "INSERT INTO daily_transfers (sender_card_no, receiver_card_no, amount, transfer_date, status) VALUES ('$senderUsername', '$receiverIBAN', $amount, CURDATE(), '$status')";
    $conn->query($insertTransferQuery);

    // Redirect to a result page after processing
    if ($status === "FAILED") {
        header("Location: transfer_result.php?error=Invalid receiver IBAN");
    } else {
        header("Location: transfer_result.php?success=Transfer successful");
    }
    exit();
}

function generateTrackingCode() {
    // Use a combination of timestamp, and random elements for uniqueness
    $timestamp = time(); // Current timestamp
    $randomString = bin2hex(random_bytes(4)); // Generate a random hexadecimal string (8 characters)

    // Combine elements to create the tracking code
    $trackingCode = "TR-" . $timestamp . "-" . $randomString;

    return $trackingCode;
}
?>
