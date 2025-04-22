<?php
// Start session and require login
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

// Check if the request is a POST — aka someone hit submit
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Escape those inputs because you don’t want random SQL monsters
    $title = $conn->real_escape_string($_POST['title']);
    $content = $conn->real_escape_string($_POST['content']);

    // Insert the new note into the database
    $user_id = $_SESSION['user_id'];
    $sql = "INSERT INTO notes (user_id, title, content) VALUES ('$user_id', '$title', '$content')";
    

    if ($conn->query($sql) === TRUE) {
        // Success! Back to homepage to admire our handiwork
        header("Location: index.php");
        exit();
    } else {
        // Welp. That didn’t work.
        echo "Error: " . $conn->error;
    }
} else {
    // Someone tried to GET this page? Nah.
    echo "Nothing to see here.";
}
