<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }

        body {
            min-height: 100vh;
            background: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            width: 100%;
            max-width: 500px;
            padding: 2.5rem;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            text-align: center;
        }

        h1 {
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
            color: #111827;
        }

        .role {
            font-size: 0.95rem;
            color: #6b7280;
            margin-bottom: 2rem;
        }

        .logout-btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            background: #111827;
            color: white;
            text-decoration: none;
            transition: 0.2s ease;
        }

        .logout-btn:hover {
            background: #1f2937;
        }
    </style>
</head>
<body>

<div class="card">
    <h1>
        Hello, <?php echo htmlspecialchars($_SESSION['username']); ?>
    </h1>

    <div class="role">
        Logged in as <?php echo htmlspecialchars($_SESSION['role']); ?>
    </div>

    <a class="logout-btn" href="logout.php">Logout</a>
</div>

</body>
</html>