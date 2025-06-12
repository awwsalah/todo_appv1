<?php
require 'config.php';
if (empty($_SESSION['user_id'])) {
    header('Location: login.php'); exit;
}
$userId = $_SESSION['user_id'];
// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['description'])) {
        $stmt = $pdo->prepare('INSERT INTO tasks (user_id, description, sort_order) VALUES (?,?,?)');
        // determine next order
        $max = $pdo->query("SELECT IFNULL(MAX(sort_order),0) FROM tasks WHERE user_id=$userId")->fetchColumn();
        $stmt->execute([$userId, $_POST['description'], $max+1]);
    }
    header('Location: index.php'); exit;
}
// Fetch tasks
$stmt = $pdo->prepare('SELECT * FROM tasks WHERE user_id = ? ORDER BY sort_order ASC');
$stmt->execute([$userId]);
$tasks = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>To‑Do List</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
</head>
<body>
  <div class="todo-container">
    <h2 class="todo-header">Your Tasks <a class="logout-link" href="logout.php">(Logout)</a></h2>
    <form class="todo-form" method="post">
      <input class="todo-input" name="description" placeholder="New task" required>
      <button class="todo-add-btn">Add</button>
    </form>
    <ul id="task-list" class="todo-list">
      <?php foreach ($tasks as $t): ?>
      <li data-id="<?= $t['id'] ?>" class="todo-item<?= $t['is_done']? ' done':'' ?>">
        <span class="todo-desc"><?= htmlspecialchars($t['description']) ?></span>
        <a class="todo-action" href="mark_done.php?id=<?= $t['id'] ?>"><?= $t['is_done']? 'Undo':'Done' ?></a>
        <a class="todo-action delete" href="delete_task.php?id=<?= $t['id'] ?>">Delete</a>
      </li>
      <?php endforeach; ?>
    </ul>
  </div>
<script src="assets/js/app.js"></script>
</body>
</html>