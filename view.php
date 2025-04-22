<?php
// Optional login protection — remove if you want public viewing
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM notes WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($note = $result->fetch_assoc()):
        if ($note['user_id'] !== $_SESSION['user_id']) {
            echo "Access denied. That's not your note.";
            exit();
        }
        
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= htmlspecialchars($note['title']) ?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <h1><?= htmlspecialchars($note['title']) ?></h1>
    <p><?= nl2br(htmlspecialchars($note['content'])) ?></p>
    <small>Posted on <?= $note['created_at'] ?></small>

    <hr>
    <a href="edit.php?id=<?= $note['id'] ?>">Edit</a> | 
    <a href="delete.php?id=<?= $note['id'] ?>" onclick="return confirm('Delete this note forever?');">Delete</a> |
    <a href="index.php">&larr; Back to all notes</a>

</body>
</html>

<?php
    else:
        echo "Note not found. Maybe it got deleted?";
    endif;
} else {
    echo "Invalid note ID.";
}
