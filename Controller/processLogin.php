<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bank";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Start the session
session_start();

// Login process
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE username='$username'";

    $result = $conn->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row["password"])) {
                // Set user_id in session
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                header("Location: ../dashboard.php");
                exit(); // Ensure script stops execution after header
            } else {
                $_SESSION['error'] = "Invalid password";
                header("Location: ../View/login_page");
                exit();
            }
        } else {
            $_SESSION['error'] = "User not found";
            header("Location: ../View/login_page");
            exit();
        }
    } else {
        $_SESSION['error'] = "Error in the query: " . $conn->error;
        header("Location: ../View/login_page");
        exit();
    }
}

$conn->close();
?>
