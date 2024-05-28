<!-- views/home.php -->
<?php
include '../src/db.php';
include '../src/middleware.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="stylesheet" href="/assets/style.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <h2>Published Blogs</h2>
        <?php
        $stmt = $conn->prepare("SELECT * FROM blogs WHERE status = 'published'");
        $stmt->execute();
        $blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($blogs as $blog) {
            echo "<h3>{$blog['title']}</h3>";
            echo "<p>" . substr($blog['content'], 0, 300) . "... <a href='/views/blog.php?id={$blog['id']}'>Read more</a></p>";
        }
        ?>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
