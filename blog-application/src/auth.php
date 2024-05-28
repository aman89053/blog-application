<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action == 'register') {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);

        if ($stmt->execute()) {
            $_SESSION['message'] = 'Registration successful! You can now login.';
            header('Location: /views/login.php');
        } else {
            $_SESSION['error'] = 'Registration failed. Please try again.';
            header('Location: /views/register.php');
        }
    } elseif ($action == 'login') {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_role'] = $user['role'];
            header('Location: /index.php');
        } else {
            $_SESSION['error'] = 'Invalid email or password.';
            header('Location: /views/login.php');
        }
    } elseif ($action == 'forgot_password') {
        $email = $_POST['email'];

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $new_password = bin2hex(random_bytes(4)); // Generate a random 8-character password
            $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

            $stmt = $conn->prepare("UPDATE users SET password = :password WHERE email = :email");
            $stmt->bindParam(':password', $hashed_password);
            $stmt->bindParam(':email', $email);

            if ($stmt->execute()) {
                mail($email, "Password Reset", "Your new password is: $new_password");
                $_SESSION['message'] = 'A new password has been sent to your email.';
                header('Location: /views/login.php');
            } else {
                $_SESSION['error'] = 'Failed to reset password. Please try again.';
                header('Location: /views/forgot_password.php');
            }
        } else {
            $_SESSION['error'] = 'No account found with that email address.';
            header('Location: /views/forgot_password.php');
        }
    }
}
?>
