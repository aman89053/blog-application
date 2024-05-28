<!-- middleware functions to restrict access to specific pages. For example, restrict access to the admin page and the blog creation page. -->
<?php
include '../src/middleware.php';
redirect_if_not_admin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Page</title>
    <link rel="stylesheet" href="/assets/style.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <h2>Admin Dashboard</h2>
        <p>Welcome, Admin!</p>
        <!-- Admin functionalities go here -->
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
