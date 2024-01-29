
<?php
// Start the session
session_start();

// Check if the user is not logged in, redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: View/login_page.php");
    exit();
}
$username = $_SESSION['username'];


// Logout process
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
    <title>User Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
    <link rel="stylesheet" href="css/dashboarStyles.css">

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
                <a class="nav-link" href="dashboard.php">Dashboard</a>
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
    <div class="jumbotron">
    <h1 class="display-4">Welcome, <?php echo $username; ?>!</h1>
            <p class="lead">This is your personalized dashboard.</p>
        <hr class="my-4">
        <p>Feel free to explore the available options:</p>

        <div class="row dashboard-options">
            <div class="col-md-4" onclick="location.href='View/Create_Bank_Account.php';">
                <div class="option-card">
                    <i class="fas fa-university"></i>
                    <h4>Create Bank Account</h4>
                </div>
            </div>
            <div class="col-md-4" onclick="location.href='View/Transfer_CtC.php';">
                <div class="option-card">
                    <i class="fas fa-exchange-alt"></i>
                    <h4>Transfer (Card to Card)</h4>
                </div>
            </div>
            <div class="col-md-4" onclick="location.href='View/Transfer_Paya.php';">
                <div class="option-card">
                    <i class="fas fa-exchange-alt"></i>
                    <h4>Transfer (Paya)</h4>
                </div>
            </div>
        </div>

        <div class="row dashboard-options">
            <div class="col-md-4" onclick="location.href='View/Transfer_Satna.php';">
                <div class="option-card">
                    <i class="fas fa-exchange-alt"></i>
                    <h4>Transfer (Satna)</h4>
                </div>
            </div>
            <div class="col-md-4" onclick="location.href='View/Transaction_History.php';">
                <div class="option-card">
                    <i class="fas fa-history"></i>
                    <h4>Transactions History</h4>
                </div>
            </div>
            <div class="col-md-4" onclick="location.href='View/Check_Transaction.php';">
                <div class="option-card">
                    <i class="fas fa-search"></i>
                    <h4>Check Transaction</h4>
                </div>
            </div>
        </div>
    </div>
</div>
<footer class="footer">
    <div class="container">
        <p>&copy; <?php echo date('Y M D H:i:s'); ?> </p>
        <p>Bank | All rights reserved</p>
        <p>Connect with us on <i class="fab fa-twitter"></i> <i class="fab fa-facebook"></i> <i class="fab fa-linkedin"></i></p>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
