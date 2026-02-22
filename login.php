<?php
/*
- Validation
- session_regenerate_id()
*/

require "db.php";

$stmt = $pdo->prepare("SELECT * FROM basic_user_auth WHERE user=:user");
$stmt = $pdo->execute(['user' => $username]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && hash('sha256', $password) === $user['pass']) {
    session_regenerate_id(true); // prevent session fixation

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['name'];
    $_SESSION['role'] = $user['role'];

    header("Location: dashboard.php");
    exit;
} else {
    $error = "Invalid Credentials.";
}
?>