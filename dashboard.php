<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>

<h1>Hello, <?php echo htmlspecialchars($_SESSION['username']); ?></h1>
<h3>Logged in as <?php echo htmlspecialchars($_SESSION['role']); ?></h3>

<a href="logout.php">Logout</a>