<?php
require 'config.php';
if (isset($_GET['id'], $_SESSION['user_id'])) {
    $stmt = $pdo->prepare('UPDATE tasks SET is_done = 1 - is_done WHERE id = ? AND user_id = ?');
    $stmt->execute([$_GET['id'], $_SESSION['user_id']]);
}
header('Location: index.php'); exit;