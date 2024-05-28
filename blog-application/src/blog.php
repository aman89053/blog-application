<!--to handle blog creation and other CRUD operations -->
<?php
session_start();
include 'db.php';
include 'middleware.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action == 'create' && (is_admin() || is_author())) {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $author_id = $_SESSION['user_id'];

        $stmt = $conn->prepare("INSERT INTO blogs (title, content, author_id) VALUES (:title, :content, :author_id)");
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':author_id', $author_id);

        if ($stmt->execute()) {
            $_SESSION['message'] = 'Blog created successfully!';
            header('Location: /index.php');
        } else {
            $_SESSION['error'] = 'Failed to create blog. Please try again.';
            header('Location: /views/create_blog.php');
        }
    }
}
?>
