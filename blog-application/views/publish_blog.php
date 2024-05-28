<!-- views/publish_blog.php -->
<?php
include '../src/middleware.php';
redirect_if_not_admin();

if (!isset($_GET['id'])) {
    header('Location: /index.php');
    exit();
}

$blog_id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM blogs WHERE id = :id");
$stmt->bindParam(':id', $blog_id);
$stmt->execute();
$blog = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$blog) {
    header('Location: /index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Publish Blog</title>
    <link rel="stylesheet" href="/assets/style.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <h2>Publish Blog</h2>
        <p>Are you sure you want to publish this blog?</p>
        <form action="/src/blog.php" method="POST">
            <input type="hidden" name="action" value="publish">
            <input type="hidden" name="id" value="<?php echo $blog_id; ?>">
            <button type="submit">Publish</button>
        </form>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
