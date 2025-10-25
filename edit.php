<?php
include_once './assets/db_connection.php';


$task_id = $_GET['id'] ?? null;

if (!$task_id) {
    header("Location: index.php");
    exit;
}


$stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = ?");
$stmt->execute([$task_id]);
$task = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$task) {
    header("Location: index.php");
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_task'])) {
    $task_name = $_POST['task_name'];
    $task_description = $_POST['task_description'];
    
    $stmt = $pdo->prepare("UPDATE tasks SET task_name = ?, task_description = ? WHERE id = ?");
    $stmt->execute([$task_name, $task_description, $task_id]);
    
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <link rel="stylesheet" href="./css/styles.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Edit Task</h1>
            <a href="index.php" class="back-link">← Back to List</a>
        </header>
        
        <main>
            <section class="edit-task">
                <form method="POST" class="task-form">
                    <input type="text" name="task_name" value="<?php echo htmlspecialchars($task['task_name']); ?>" required>
                    <textarea name="task_description"><?php echo htmlspecialchars($task['task_description']); ?></textarea>
                    <div class="form-actions">
                        <button type="submit" name="update_task" class="update-btn">Update Task</button>
                        <a href="index.php" class="cancel-btn">Cancel</a>
                    </div>
                </form>
            </section>
        </main>
    </div>
    
    <footer>
        <section id="copyright">
            <p>&copy; Samuel Hula 2025</p>
        </section>
    </footer>
</body>
</html>