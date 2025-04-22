<?php
// Start session and protect the page from unauthorized access
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

// Check if a valid note ID is passed
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Form was submitted — time to update the note
        $title = $conn->real_escape_string($_POST['title']);
        $content = $conn->real_escape_string($_POST['content']);

        // Always update only the current user's note
        $stmt = $conn->prepare("UPDATE notes SET title = ?, content = ? WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ssii", $title, $content, $id, $_SESSION['user_id']);

        if ($stmt->execute()) {
            header("Location: index.php");
            exit();
        } else {
            echo "Error updating note. Server is moody.";
        }
    } else {
        // Load the note data to pre-fill the form
        $stmt = $conn->prepare("SELECT * FROM notes WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($note = $result->fetch_assoc()) {
            // Ownership check — don't let users edit someone else's note
            if ($note['user_id'] !== $_SESSION['user_id']) {
                echo "Access denied. This note is not yours, sneaky one.";
                exit();
            }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Note</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <h1>Edit Note</h1>
    <form method="POST">
        <input type="text" name="title" value="<?= htmlspecialchars($note['title']) ?>" required>
        <textarea name="content" rows="6" required><?= htmlspecialchars($note['content']) ?></textarea>
        <button type="submit">Update Note</button>
    </form>
    <br>
    <a href="index.php">&larr; Cancel</a>

</body>
</html>

<?php
        } else {
            echo "Note not found. Did it ever exist?";
        }
    }
} else {
    echo "Invalid note ID.";
}
