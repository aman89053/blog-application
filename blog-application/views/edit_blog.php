<!-- Create a page for editing blogs -->
<?php
include '../src/middleware.php';
include '../src/db.php';

redirect_if_not_logged_in();

$blog_id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM blogs WHERE id = :id");
$stmt->bindParam(':id', $blog_id);
$stmt->execute();
$blog = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$blog || (!is_admin() && $blog['author_id'] != $_SESSION['user_id'])) {
    header('Location: /index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Blog</title>
    <link rel="stylesheet" href="/assets/style.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <h2>Edit Blog</h2>
        <form action="/src/blog.php" method="POST">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="blog_id" value="<?php echo $blog['id']; ?>">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" value="<?php echo $blog['title']; ?>" required>
            <label for="content">Content:</label>
            <textarea id="content" name="content" required><?php echo $blog['content']; ?></textarea>
            <button type="submit">Update</button>
        </form>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
