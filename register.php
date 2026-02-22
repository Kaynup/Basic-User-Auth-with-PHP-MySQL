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

    // Validations
    if (strlen($username) < 3) {
        $errors[] = "Username must be at least 3 characters.";
    }

    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters.";
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

            $stmt->exceute([
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

<h2>Register</h2>
<?php foreach ($error as $error): ?>
    <p style="color:red;"><?php echo $error; ?><p>
<?php endforeach; ?>

<form method="POST">
    <input name="username" placeholder="Username" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <button type="submit">Register</button>
</form>