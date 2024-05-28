<?php
session_start();
include 'db.php';

function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function is_admin() {
    return is_logged_in() && $_SESSION['user_role'] == 'admin';
}

function is_author() {
    return is_logged_in() && $_SESSION['user_role'] == 'author';
}

function is_subscriber() {
    return is_logged_in() && $_SESSION['user_role'] == 'subscriber';
}

function redirect_if_not_logged_in() {
    if (!is_logged_in()) {
        header('Location: /views/login.php');
        exit();
    }
}

function redirect_if_not_admin() {
    if (!is_admin()) {
        header('Location: /index.php');
        exit();
    }
}
?>
