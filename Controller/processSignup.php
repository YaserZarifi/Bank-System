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

// Signup process
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newUsername = $_POST["newUsername"];
    $newPassword = password_hash($_POST["newPassword"], PASSWORD_DEFAULT);
    $name = $_POST["name"];
    $familyName = $_POST["FamilyName"];
    $n_ID = $_POST["n_ID"];

    // Check if the username is already taken
    $checkUsernameQuery = "SELECT * FROM users WHERE username = '$newUsername'";
    $checkUsernameResult = $conn->query($checkUsernameQuery);

    if ($checkUsernameResult->num_rows > 0) {
        // Set error message in session
        $_SESSION['error'] = "Username is already taken. Please choose a different one.";
        header("Location: ../View/signup_page.php");
        exit();
    }

    // Check if the n_ID is already registered
    $checkNIDQuery = "SELECT * FROM users WHERE n_ID = '$n_ID'";
    $checkNIDResult = $conn->query($checkNIDQuery);

    if ($checkNIDResult->num_rows > 0) {
        // Set error message in session
        $_SESSION['error'] = "A user with the same National ID already exists.";
        header("Location: ../View/signup_page.php");
        exit();
    }

    // Insert the new user into the database
    $sql = "INSERT INTO users (name, last_name, username, password, n_ID) VALUES ('$name', '$familyName', '$newUsername', '$newPassword','$n_ID')";

    if ($conn->query($sql) === TRUE) {
        // Signup successful, redirect to login page
        header("Location: ../View/login_page.php");
        exit(); // Ensure script stops execution after header
    } else {
        // Set error message in session
        $_SESSION['error'] = "Error: " . $sql . "<br>" . $conn->error;
        header("Location: ../View/signup_page.php");
        exit();
    }
}

$conn->close();
?>
