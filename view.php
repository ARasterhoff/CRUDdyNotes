<?php
include 'db.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];
    
    // get the note that matches the ID
    $stmt = $conn->prepare("SELECT * FROM notes WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($note = $result->fetch_assoc()):
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
        echo "Note not found. Maybe it ran away.";
    endif;
} else {
    echo "Invalid note ID. You can't just guess numbers, hacker.";
}
