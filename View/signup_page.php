<?php
session_start();
if (isset($_SESSION['error'])) {
    echo "<div class='alert alert-danger'>{$_SESSION['error']}</div>";
    unset($_SESSION['error']); // Clear the error message
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login and Signup</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
    <link rel="stylesheet" href="../css/signupStyles.css">

</head>
<body>

<div class="container">

    <h2 class="text-center mb-4">Sign Up</h2>
    <form action="../Controller/processSignup.php" method="post" class="<?php echo isset($errorMessage) ? 'has-error' : ''; ?>">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control <?php echo isset($nameError) ? 'is-invalid' : ''; ?>" id="name" name="name" required>

        </div>
        <div class="form-group">
            <label for="FamilyName">Family Name:</label>
            <input type="text" class="form-control <?php echo isset($familyNameError) ? 'is-invalid' : ''; ?>" id="FamilyName" name="FamilyName" required>

        </div>
        <div class="form-group">
            <label for="n_ID">National ID:</label>
            <input type="text" class="form-control <?php echo isset($nIDError) ? 'is-invalid' : ''; ?>" id="n_ID" name="n_ID" required>

        </div>
        <div class="form-group">
            <label for="newUsername">New Username:</label>
            <input type="text" class="form-control <?php echo isset($usernameError) ? 'is-invalid' : ''; ?>" id="newUsername" name="newUsername" required>

        </div>
        <div class="form-group">
            <label for="newPassword">New Password:</label>
            <input type="password" class="form-control <?php echo isset($passwordError) ? 'is-invalid' : ''; ?>" id="newPassword" name="newPassword" required>

        </div>
        <button type="submit" class="btn btn-success btn-block">Sign Up</button>
    </form>
    <p class="mt-3">Already have an account? <a href="login_page.php">Login here</a></p>

</div>


</body>
</html>
