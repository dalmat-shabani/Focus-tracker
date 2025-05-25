<?php
require 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username']);
  $password = $_POST['password'];

  if ($username && $password) {
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (username, password_hash) VALUES (?, ?)");

    try {
      $stmt->execute([$username, $hash]);
      $_SESSION['user_id'] = $pdo->lastInsertId();
      $_SESSION['username'] = $username;
      header("Location: index.php");
      exit;
    } catch (PDOException $e) {
      $error = "Username already taken.";
    }
  } else {
    $error = "Please fill in all fields.";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Register - Smart Focus Tracker</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="panel main-panel" style="max-width: 400px; margin: 60px auto;">
    <h2>Register</h2>
    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST">
      <input type="text" name="username" placeholder="Username" required /><br><br>
      <input type="password" name="password" placeholder="Password" required /><br><br>
      <button type="submit" class="auth-button">Register</button>
    </form>
    <p style="margin-top:10px;">Already have an account? <a href="login.php">Login here</a></p>
  </div>
</body>
</html>
