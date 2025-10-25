<?php
    include_once './assets/db_connection.php';
    
    // Handle form submissions
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['add_task'])) {
            $task_name = $_POST['task_name'];
            $task_description = $_POST['task_description'];
            
            $stmt = $pdo->prepare("INSERT INTO tasks (task_name, task_description) VALUES (?, ?)");
            $stmt->execute([$task_name, $task_description]);
            header("Location: index.php");
            exit;
        }
        
        if (isset($_POST['delete_task'])) {
            $task_id = $_POST['task_id'];
            $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = ?");
            $stmt->execute([$task_id]);
            header("Location: index.php");
            exit;
        }
        
        if (isset($_POST['toggle_complete'])) {
            $task_id = $_POST['task_id'];
            $stmt = $pdo->prepare("UPDATE tasks SET is_completed = NOT is_completed WHERE id = ?");
            $stmt->execute([$task_id]);
            header("Location: index.php");
            exit;
        }
    }
    
    $stmt = $pdo->query("SELECT * FROM tasks ORDER BY created_at DESC");
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To Do List</title>
    <link rel="stylesheet" href="./css/styles.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>My To-Do List</h1>
        </header> 
        <main>
            <section class="add-task">
                <h2>Add New Task</h2>
                <form method="POST" class="task-form">
                    <input type="text" name="task_name" placeholder="Task name" required>
                    <textarea name="task_description" placeholder="Task description"></textarea>
                    <button type="submit" name="add_task">Add Task</button>
                </form>
            </section>
            
            <section class="tasks-list">
                <h2>Tasks</h2>
                <?php if (empty($tasks)): ?>
                    <p class="no-tasks">No tasks yet. Add your first task above!</p>
                <?php else: ?>
                    <?php foreach ($tasks as $task): ?>
                        <div class="task-item <?php echo $task['is_completed'] ? 'completed' : ''; ?>">
                            <div class="task-content">
                                <h3><?php echo htmlspecialchars($task['task_name']); ?></h3>
                                <p><?php echo htmlspecialchars($task['task_description']); ?></p>
                                <small>Created: <?php echo date('M j, Y g:i A', strtotime($task['created_at'])); ?></small>
                            </div>
                            <div class="task-actions">
                                <form method="POST" class="inline-form">
                                    <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                                    <button type="submit" name="toggle_complete" class="complete-btn">
                                        <?php echo $task['is_completed'] ? 'Undo' : 'Complete'; ?>
                                    </button>
                                </form>
                                
                                <a href="edit.php?id=<?php echo $task['id']; ?>" class="edit-btn">Edit</a>
                                
                                <form method="POST" class="inline-form" onsubmit="return confirm('Are you sure you want to delete this task?');">
                                    <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                                    <button type="submit" name="delete_task" class="delete-btn">Delete</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
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