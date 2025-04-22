<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];

    // Step 1: Get the note first
    $stmt = $conn->prepare("SELECT * FROM notes WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($note = $result->fetch_assoc()) {
        // Step 2: Ownership check
        if ($note['user_id'] !== $_SESSION['user_id']) {
            echo "Access denied. Nice try, but that note’s not yours.";
            exit();
        }

        // Step 3: Now delete it
        $stmt = $conn->prepare("DELETE FROM notes WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            header("Location: index.php");
            exit();
        } else {
            echo "Failed to delete. The note resists.";
        }
    } else {
        echo "Note not found.";
    }
} else {
    echo "Invalid note ID.";
}
