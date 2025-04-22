<?php
// db connection time. don't forget to include this or nothing works.
include 'db.php';

// basic POST check — is someone trying to submit a new note?
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // escape inputs to avoid SQL injection, even if it's local — good habit!
    $title = $conn->real_escape_string($_POST['title']);
    $content = $conn->real_escape_string($_POST['content']);

    // insert the new note into the database
    $sql = "INSERT INTO notes (title, content) VALUES ('$title', '$content')";

    if ($conn->query($sql) === TRUE) {
        // success! now go back to the homepage
        header("Location: index.php");
        exit();
    } else {
        // something broke. shrug.
        echo "Error: " . $conn->error;
    }
} else {
    // someone tried to access this page directly with GET — nope.
    echo "Nothing to see here.";
}
