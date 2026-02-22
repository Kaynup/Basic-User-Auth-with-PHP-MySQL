<?php

$dsn = "mysql:host=localhost;dbname=demobase;charset=utf8mb4";
$dbUser = "shipman";
$dbPass = "StrongPassword123!";

try {
    $pdo = new PDO($dsn, $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed.");
}
?>