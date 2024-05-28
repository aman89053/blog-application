<!-- Create a form for password reset -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="/assets/style.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <h2>Forgot Password</h2>
        <form action="/src/auth.php" method="POST">
            <input type="hidden" name="action" value="forgot_password">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <button type="submit">Reset Password</button>
        </form>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
