// src/blog.php
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
    } elseif ($action == 'edit' && (is_admin() || is_author())) {
        $blog_id = $_POST['id'];
        $title = $_POST['title'];
        $content = $_POST['content'];

        $stmt = $conn->prepare("UPDATE blogs SET title = :title, content = :content WHERE id = :id AND (author_id = :author_id OR :is_admin = 1)");
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':id', $blog_id);
        $stmt->bindParam(':author_id', $_SESSION['user_id']);
        $stmt->bindValue(':is_admin', is_admin() ? 1 : 0, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $_SESSION['message'] = 'Blog updated successfully!';
            header('Location: /views/blog.php?id=' . $blog_id);
        } else {
            $_SESSION['error'] = 'Failed to update blog. Please try again.';
            header('Location: /views/edit_blog.php?id=' . $blog_id);
        }
    } elseif ($action == 'publish' && is_admin()) {
        $blog_id = $_POST['id'];

        $stmt = $conn->prepare("UPDATE blogs SET status = 'published' WHERE id = :id");
        $stmt->bindParam(':id', $blog_id);

        if ($stmt->execute()) {
            $_SESSION['message'] = 'Blog published successfully!';
            header('Location: /views/blog.php?id=' . $blog_id);
        } else {
            $_SESSION['error'] = 'Failed to publish blog. Please try again.';
            header('Location: /views/publish_blog.php?id=' . $blog_id);
        }
    }
}
?>
