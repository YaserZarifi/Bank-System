<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>User Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/profileStyles.css">

</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark">
    <a class="navbar-brand" href="#">User Profile</a>
    <!-- Add your navigation links if needed -->
</nav>

<div class="container">
    <div class="jumbotron">
        <h1 class="display-4">User Profile - <?php echo $username; ?></h1>
        <hr class="my-4">
        <div class="profile-info">
            <!-- Display user information here -->
            <p><strong>Username:</strong> <?php echo $username; ?></p>
            <!-- Add more user information as needed -->
        </div>
        <a class="btn btn-danger" href="Controller/deleteAccount.php" role="button">Delete Account</a>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
