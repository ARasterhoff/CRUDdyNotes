<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if this user exists in the DB
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        // Compare entered password with hashed password
        if (password_verify($password, $user['password'])) {
            // Store user info in session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: index.php");
            exit();
        } else {
            $error = "Wrong password. Try again, my friend.";
        }
    } else {
        $error = "User not found. Did you mistype?";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - CRUDdyNotes</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <h1>Login to CRUDdyNotes</h1>
    <?php if (isset($error)) echo "<p><strong>$error</strong></p>"; ?>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>

</body>
</html>
