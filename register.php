<?php
require 'config.php';
$error = '';
if (
    !empty($_POST['username']) && !empty($_POST['password'])
) {
    $stmt = $pdo->prepare('INSERT INTO users (username,password) VALUES (?,?)');
    $hash = password_hash($_POST['password'], PASSWORD_BCRYPT);
    try {
        $stmt->execute([$_POST['username'], $hash]);
        header('Location: login.php'); exit;
    } catch (Exception $e) {
        $error = 'Username taken.';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Register</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <div class="register-card">
    <h2 class="todo-header">Register</h2>
    <?php if (!empty($error)) echo "<p class='error-msg'>$error</p>"; ?>
    <form class="todo-form" method="post">
      <input class="todo-input" name="username" placeholder="Username" required><br>
      <input class="todo-input" name="password" type="password" placeholder="Password" required><br>
      <button class="todo-add-btn">Register</button>
    </form>
    <p><a class="todo-action" href="login.php">Login</a></p>
  </div>
</body>
</html>