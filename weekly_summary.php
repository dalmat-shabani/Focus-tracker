<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}

$userId = $_SESSION['user_id'];

$stmt = $pdo->prepare("
  SELECT 
    DATE(timestamp) as day,
    COUNT(*) as sessions,
    ROUND(AVG(score), 2) as avg_score,
    SUM(focused) as total_focused
  FROM focus_sessions
  WHERE user_id = ? AND timestamp >= DATE_SUB(NOW(), INTERVAL 7 DAY)
  GROUP BY day
  ORDER BY day DESC
");

$stmt->execute([$userId]);
$rows = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Weekly Focus Summary</title>
  <link rel="stylesheet" href="style.css">
  <script>
    if (localStorage.getItem('theme') === 'dark') {
      document.documentElement.classList.add('dark');
    }
  </script>
</head>
<body>
  <header class="site-header">
    <div class="header-inner">
      <h1 class="site-title">Smart Focus Tracker</h1>
      <nav class="site-nav">
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="about.php">About</a></li>
          <li><a href="contact.php">Contact</a></li>
          <li><a href="weekly_summary.php" aria-current="page">Weekly Summary</a></li>
          <li><a href="logout.php">Logout</a></li>
        </ul>
      </nav>
      <label class="theme-switch" for="theme-toggle">
        <input type="checkbox" id="theme-toggle" />
        <span class="slider"></span>
      </label>
    </div>
  </header>

  <div class="panel main-panel" style="max-width: 800px; margin: 60px auto;">
    <h2>🗓 Weekly Focus Summary</h2>

    <?php if (empty($rows)): ?>
      <p>No session data available from the past 7 days.</p>
    <?php else: ?>
      <table style="width:100%; border-collapse: collapse; margin-top: 20px;">
        <thead>
          <tr class="summary-header-row">
            <th style="padding: 10px;">Date</th>
            <th>Sessions</th>
            <th>Avg. Focus Score</th>
            <th>Total Focused (s)</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($rows as $row): ?>
            <tr class="summary-data-row">
              <td style="padding: 10px;"><?php echo htmlspecialchars($row['day']); ?></td>
              <td><?php echo $row['sessions']; ?></td>
              <td><?php echo $row['avg_score']; ?>%</td>
              <td><?php echo $row['total_focused']; ?>s</td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>

    <p style="margin-top: 20px;"><a href="index.php">← Back to Tracker</a></p>
  </div>

  <script src="script.js"></script>
</body>
</html>
