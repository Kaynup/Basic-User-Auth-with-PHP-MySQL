<?php
/*
- Validation
- session_regenerate_id()
*/
session_start();
require "db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST["username"] ?? '');
    $password = $_POST["password"] ?? '';

    if ($username === '' || $password === '') {
        $error = "Both fields are required.";
    } else {

        $stmt = $pdo->prepare(
            "SELECT * FROM basic_user_auth WHERE user = :user"
        );

        $stmt->execute(['user' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && hash('sha256', $password) === $user['pass']) {

            session_regenerate_id(true);

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['user'];
            $_SESSION['role'] = $user['role'];

            header("Location: dashboard.php");
            exit;

        } else {
            $error = "Invalid Credentials.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }

        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #1f302d, #1f302d);
        }

        .card {
            background: white;
            padding: 2rem;
            width: 100%;
            max-width: 400px;
            border-radius: 12px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        h2 {
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .error {
            background: #fee2e2;
            color: #b91c1c;
            padding: 0.75rem;
            border-radius: 6px;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        input {
            width: 100%;
            padding: 0.75rem;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 1rem;
            transition: 0.2s ease;
        }

        input:focus {
            border-color: #c6d26a;
            outline: none;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
        }

        button {
            width: 100%;
            padding: 0.75rem;
            border: none;
            border-radius: 8px;
            background: #191925;
            color: white;
            font-size: 1rem;
            cursor: pointer;
            transition: 0.2s ease;
        }

        button:hover {
            background: #3c3c40;
        }

        .footer {
            margin-top: 1rem;
            text-align: center;
            font-size: 0.9rem;
        }

        .footer a {
            color: #5aa8e9;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="card">
    <h2>Login</h2>

    <?php if ($error): ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <input type="text" name="username" placeholder="Username" required>
        </div>

        <div class="form-group">
            <input type="password" name="password" placeholder="Password" required>
        </div>

        <button type="submit">Login</button>
    </form>

    <div class="footer">
        Don’t have an account? <a href="register.php">Register</a>
    </div>
</div>

</body>
</html>