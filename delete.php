<?php
include 'db.php';

// make sure we got a valid ID
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];

    // delete the note — gone forever (unless you back up, which you don’t)
    $stmt = $conn->prepare("DELETE FROM notes WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // success. back to main.
        header("Location: index.php");
        exit();
    } else {
        echo "Error deleting note. It's still here. Sorry.";
    }
} else {
    echo "Invalid note ID. Nothing deleted. Move along.";
}
