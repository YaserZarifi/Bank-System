<?php
//// Start session
//session_start();
//
//// Check if the user is not logged in, redirect to login page
//if (!isset($_SESSION['user_id'])) {
//    header("Location: ../View/login_page.php");
//    exit();
//}
//
//// Add your database connection code here
//$servername = "localhost";
//$username = "root";
//$password = "";
//$dbname = "bank";
//
//$conn = new mysqli($servername, $username, $password, $dbname);
//
//// Check connection
//if ($conn->connect_error) {
//    die("Connection failed: " . $conn->connect_error);
//}
//
//// Fetch the sender's username from the session
//$senderUsername = $_SESSION['username'];
//
//// Check if the form is submitted
//if ($_SERVER["REQUEST_METHOD"] == "POST") {
//    $receiverCard = $_POST["receiverCard"];
//    $amount = $_POST["amount"];
//
//    $checkCardQuery = "SELECT * FROM accounts WHERE card_number = '$receiverCard'";
//    $checkCardResult = $conn->query($checkCardQuery);
//    $nums = $checkCardResult->num_rows;
//
//    if ($nums === 0) {
//        // Receiver card number not found in the database
//        header("Location: transfer_result.php?error=Invalid receiver card number");
//        exit();
//    }
//
//    // Add logic to check daily transfer limit
//    $dailyLimit = 10000000; // 10 million
//    $dailyTransfersQuery = "SELECT SUM(amount) AS total FROM daily_transfers WHERE sender_card_no = '$senderUsername' AND transfer_date = CURDATE()";
//    $dailyTransfersResult = $conn->query($dailyTransfersQuery);
//
//    $dailyTransfersData = $dailyTransfersResult->fetch_assoc();
//    $totalTransferredToday = $dailyTransfersData['total'] ?? 0;
//
//    if (($totalTransferredToday + $amount) > $dailyLimit) {
//        // Exceeded daily limit
//        header("Location: transfer_result.php?error=Daily limit exceeded");
//        exit();
//    }
//
//    $balance_query = "SELECT balance from accounts where user_id = (SELECT id from users where username = '$senderUsername')";
//    $result_balance = $conn->query($balance_query);
//
//    $balance_data = $result_balance->fetch_assoc();
//    $balance = $balance_data['balance'];
//
//    if ($balance < $amount) {
//        // Insufficient
//        header("Location: transfer_result.php?error=Insufficient Balance");
//        exit();
//    }
//    // 1. Update sender's balance
//    $updateSenderBalanceQuery = "UPDATE accounts SET balance = balance - $amount WHERE user_id = (SELECT id FROM users WHERE username = '$senderUsername')";
//    $conn->query($updateSenderBalanceQuery);
//
//    // 2. Update receiver's balance
//    $updateReceiverBalanceQuery = "UPDATE accounts SET balance = balance + $amount WHERE card_number = '$receiverCard'";
//    $conn->query($updateReceiverBalanceQuery);
//
//    // 4. Insert the transfer record into the transactions table
//    $trackingCode = generateTrackingCode();
//    $insertTransactionQuery = "INSERT INTO transactions (source_account, destination_account, amount, transaction_type, tracking_code, status) VALUES (
//        (SELECT card_number FROM accounts WHERE user_id = (SELECT id FROM users WHERE username = '$senderUsername') LIMIT 1),
//        (SELECT card_number FROM accounts WHERE card_number = '$receiverCard' LIMIT 1),
//        $amount, 'Card to Card', '$trackingCode', 'SUCCESS'
//    )";
//    $conn->query($insertTransactionQuery);
//
//    // 5. Insert the transfer record into the daily_transfers table
//    $insertTransferQuery = "INSERT INTO daily_transfers (sender_card_no, receiver_card_no, amount, transfer_date) VALUES ('(SELECT card_number FROM accounts WHERE user_id = (SELECT id FROM users WHERE username = '$senderUsername') LIMIT 1)', '$receiverCard', '$amount', CURDATE())";
//    $conn->query($insertTransferQuery);
//
//    // Redirect to a success page after processing
//    header("Location: transfer_result.php?success=Transfer successful");
//    exit();
//}
//
//function generateTrackingCode() {
//    // Use a combination of timestamp, and random elements for uniqueness
//    $timestamp = time(); // Current timestamp
//    $randomString = bin2hex(random_bytes(4)); // Generate a random hexadecimal string (8 characters)
//
//    // Combine elements to create the tracking code
//    $trackingCode = "TR-" . $timestamp . "-" . $randomString;
//
//    return $trackingCode;
//}
//
//


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
    $receiverCard = $_POST["receiverCard"];
    $amount = $_POST["amount"];

    $checkCardQuery = "SELECT * FROM accounts WHERE card_number = '$receiverCard'";
    $checkCardResult = $conn->query($checkCardQuery);
    $nums = $checkCardResult->num_rows;

    if ($nums === 0) {
        // Receiver card number not found in the database
        $status = "FAILED";
    } else {
        // Add logic to check daily transfer limit
        $dailyLimit = 10000000; // 10 million

// Check if the total transferred today exceeds the daily limit
        $dailyLimit = 10000000; // 10 million
        $dailyTransfersQuery = "SELECT SUM(amount) AS total FROM daily_transfers WHERE sender_card_no = '$senderUsername' AND transfer_date = CURDATE()";
        $dailyTransfersResult = $conn->query($dailyTransfersQuery);

        $dailyTransfersData = $dailyTransfersResult->fetch_assoc();
        $totalTransferredToday = $dailyTransfersData['total'] ?? 0;

        if (($totalTransferredToday + $amount) > $dailyLimit) {
            // Exceeded daily limit
            $status = "FAILED";
            header("Location: transfer_result.php?error=Daily limit exceeded");
            $trackingCode = generateTrackingCode();
            $insertTransactionQuery = "INSERT INTO transactions (source_account, destination_account, amount, transaction_type, tracking_code, status) VALUES (
                (SELECT card_number FROM accounts WHERE user_id = (SELECT id FROM users WHERE username = '$senderUsername') LIMIT 1),
                '$receiverCard', $amount, 'Card to Card', '$trackingCode', '$status'
            )";
            $conn->query($insertTransactionQuery);
            exit();
        }

        // Check sender's balance
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
            $updateReceiverBalanceQuery = "UPDATE accounts SET balance = balance + $amount WHERE card_number = '$receiverCard'";
            $conn->query($updateReceiverBalanceQuery);
        }
    }

    // Insert the transfer record into the transactions table
    $trackingCode = generateTrackingCode();
    $insertTransactionQuery = "INSERT INTO transactions (source_account, destination_account, amount, transaction_type, tracking_code, status) VALUES (
        (SELECT card_number FROM accounts WHERE user_id = (SELECT id FROM users WHERE username = '$senderUsername') LIMIT 1),
        '$receiverCard', $amount, 'Card to Card', '$trackingCode', '$status'
    )";
    $conn->query($insertTransactionQuery);

    // Insert the transfer record into the daily_transfers table
    $insertTransferQuery = "INSERT INTO daily_transfers (sender_card_no, receiver_card_no, amount, transfer_date, status) VALUES ('$senderUsername', '$receiverCard', $amount, CURDATE(), '$status')";
    $conn->query($insertTransferQuery);

    // Redirect to a result page after processing
    if ($status === "FAILED") {
        header("Location: transfer_result.php?error=Invalid receiver card number");
    } else {
        header("Location: transfer_result.php?success=Transfer successful");
    }
    exit();
}

function generateTrackingCode()
{
    // Use a combination of timestamp, and random elements for uniqueness
    $timestamp = time(); // Current timestamp
    $randomString = bin2hex(random_bytes(4)); // Generate a random hexadecimal string (8 characters)

    // Combine elements to create the tracking code
    $trackingCode = "TR-" . $timestamp . "-" . $randomString;

    return $trackingCode;
}


?>
