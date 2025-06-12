<?php
require 'config.php';
$ids = json_decode(file_get_contents('php://input'), true);
if (is_array($ids) && isset($_SESSION['user_id'])) {
    foreach ($ids as $order => $id) {
        $stmt = $pdo->prepare('UPDATE tasks SET sort_order = ? WHERE id = ? AND user_id = ?');
        $stmt->execute([$order, $id, $_SESSION['user_id']]);
    }
    echo json_encode(['status'=>'ok']);
}