<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Simple checks
    if (strlen($username) < 3 || strlen($password) < 6) {
        $error = "Username must be at least 3 chars, password 6+ chars.";
    } else {
        // Check if username is already taken
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "That username is already taken. Try something weirder.";
        } else {
            // Hash password and insert new user
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $username, $hashed);

            if ($stmt->execute()) {
                // Success! Auto-login the new user
                $_SESSION['user_id'] = $stmt->insert_id;
                $_SESSION['username'] = $username;
                header("Location: index.php");
                exit();
            } else {
                $error = "Something went wrong. DB being dramatic?";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register - CRUDdyNotes</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <h1>Register</h1>
    <?php if (isset($error)) echo "<p><strong>$error</strong></p>"; ?>
    <form method="POST">
        <input type="text" name="username" placeholder="Pick a username" required>
        <input type="password" name="password" placeholder="Choose a password" required>
        <button type="submit">Register</button>
    </form>
    <p>Already have an account? <a href="login.php">Login here</a>.</p>

</body>
</html>
