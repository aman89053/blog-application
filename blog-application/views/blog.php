<!-- views/blog.php blog pagr==w -->
<?php
include '../src/db.php';
include '../src/middleware.php';

if (!isset($_GET['id'])) {
    header('Location: /index.php');
    exit();
}

$blog_id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM blogs WHERE id = :id");
$stmt->bindParam(':id', $blog_id);
$stmt->execute();
$blog = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$blog || ($blog['status'] != 'published' && !is_admin() && $blog['author_id'] != $_SESSION['user_id'])) {
    header('Location: /index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $blog['title']; ?></title>
    <link rel="stylesheet" href="/assets/style.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <h2><?php echo $blog['title']; ?></h2>
        <p><?php echo $blog['content']; ?></p>
        <hr>
        <h3>Comments</h3>
        <!-- Comments section goes here -->
        <?php if (is_subscriber()) { ?>
            <form action="/src/comment.php" method="POST">
                <input type="hidden" name="action" value="add_comment">
                <input type="hidden" name="blog_id" value="<?php echo $blog_id; ?>">
                <textarea name="comment" required></textarea>
                <button type="submit">Add Comment</button>
            </form>
        <?php } ?>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
