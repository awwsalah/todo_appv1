<?php
require 'config.php';
if (!empty($_POST['username'])) {
    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
    $stmt->execute([$_POST['username']]);
    $user = $stmt->fetch();
    if ($user && password_verify($_POST['password'], $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header('Location: index.php'); exit;
    }
    $error = 'Invalid credentials.';
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <div class="login-card">
    <h2 class="todo-header">Login</h2>
    <?php if (!empty($error)) echo "<p class='error-msg'>$error</p>"; ?>
    <form class="todo-form" method="post">
      <input class="todo-input" name="username" placeholder="Username" required><br>
      <input class="todo-input" name="password" type="password" placeholder="Password" required><br>
      <button class="todo-add-btn">Login</button>
    </form>
    <p><a class="todo-action" href="register.php">Register</a></p>
  </div>
</body>
</html>