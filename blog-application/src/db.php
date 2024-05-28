<?php
// src/db.php

$servername = "localhost";
$username = "root"; // replace with your MySQL username
$password = ""; // replace with your MySQL password
$dbname = "blog_app";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
