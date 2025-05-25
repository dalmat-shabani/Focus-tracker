<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
  http_response_code(401);
  exit('Not logged in');
}

$stmt = $pdo->prepare("SELECT * FROM focus_sessions WHERE user_id = ? ORDER BY timestamp DESC LIMIT 10");
$stmt->execute([$_SESSION['user_id']]);
$sessions = $stmt->fetchAll();

echo json_encode($sessions);
?>
