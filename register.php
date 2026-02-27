<?php

// Validate input
// Hash password
// Insert using PDO

session_start();
require "db.php";

$errors = [];

/* $_SERVER is an associative array automatically created by PHP that contains:
- HTTP request metadata
- Server configuration data
- Execution environment information
- It is available in all scopes without global.
- That is why it is called a superglobal.
*/

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);   // trim() removes leading and trailing white spaces to match the strings
    $password = $_POST["password"];
    $confirm_pass = $_POST["cpassword"];

    // Validations
    if (strlen($username) < 3) {
        $errors[] = "Username must be at least 3 characters.";
    }

    if ((strlen($password) < 6) || (strlen($confirm_pass) < 6)) {
        $errors[] = "Password must be at least 6 characters.";
    }

    if (!hash_equals($password, $confirm_pass)) {
        $errors[] = "Passwords do not match.";
    }

    if (empty($errors)) {

    $hash = hash('sha256', $password); // hashing in php to match with the SQL

        try {
            $stmt = $pdo->prepare(
                "INSERT INTO basic_user_auth(user, pass)
                VALUES (:user, :pass)"
            );
            /*
            This creates a prepared statement template.
            Key idea:
            - SQL structure is parsed first.
            - Data is injected separately.
            - Prevents SQL injection.
            :user and :pass are named parameters.
            */

            $stmt->execute([
                'user' => $username,
                'pass' => $hash
            ]);
            /*
            Internally PDO: Escapes data safely. Sends to MySQL as a parameterized query. So this is secure.
            */

            // header() manipulates HTTP response headers.
            header("Location: login.php");
            exit;
            /*
            header("Location: login.php");
            - Sends HTTP redirect response
            - Browser automatically loads that page
            - Must be called before output
            - Should be followed by exit;
            */

        } catch (PDOException $e) {
            $errors[] = "Username already exists.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
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

        .error-box {
            background: #fee2e2;
            color: #b91c1c;
            padding: 0.75rem;
            border-radius: 6px;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }

        .error-box ul {
            padding-left: 1.2rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        label {
            display: block;
            font-size: 0.9rem;
            margin-bottom: 0.25rem;
            color: #374151;
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
    <h2>Register</h2>

    <?php if (!empty($errors)): ?>
        <div class="error-box">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label for="username">Username</label>
            <input id="username" name="username" value="<?php echo htmlspecialchars($_POST["username"] ?? ''); ?>" required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>

        <div class="form-group">
            <label for="password">Confirm password</label>
            <input type="password" id="cpassword" name="cpassword" required>
        </div>

        <button type="submit">Register</button>
    </form>

    <div class="footer">
        Already have an account? <a href="login.php">Login</a>
    </div>
</div>

</body>
</html>