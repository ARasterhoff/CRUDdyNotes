<?php include 'db.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>CRUDdyNotes</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <h1>CRUDdyNotes</h1>
    <p><em>yes. you can write notes. no, there's no dark mode.</em></p>

    <hr>

    <h2>Add a Note</h2>
    <form action="add.php" method="POST">
        <input type="text" name="title" placeholder="Title" required>
        <textarea name="content" placeholder="Write your note..." rows="6" required></textarea>
        <button type="submit">Add Note</button>
    </form>

    <hr>

    <h2>All Notes</h2>
    <?php
    // get the notes from the db in reverse-chronological order because recency bias is real
    $result = $conn->query("SELECT * FROM notes ORDER BY created_at DESC");
    while ($row = $result->fetch_assoc()):
    ?>
        <div class="note">
            <h3>
                <a href="view.php?id=<?= $row['id'] ?>">
                    <?= htmlspecialchars($row['title']) ?>
                </a>
            </h3>
            <p><?= nl2br(htmlspecialchars(substr($row['content'], 0, 100))) ?>...</p>
            <small>Posted on <?= $row['created_at'] ?></small><br>
            <a href="edit.php?id=<?= $row['id'] ?>">Edit</a> | 
            <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this note forever?');">Delete</a>
        </div>
    <?php endwhile; ?>

</body>
</html>
