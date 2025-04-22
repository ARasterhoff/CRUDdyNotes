<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include 'db.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>CRUDdyNotes</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <h1>CRUDdyNotes</h1>
    <p><em>Logged in as <strong><?= htmlspecialchars($_SESSION['username']) ?></strong></em> |
    <a href="logout.php">Logout</a></p>

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
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM notes WHERE user_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

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
