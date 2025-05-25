<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
  http_response_code(401);
  exit('Not logged in');
}

$data = json_decode(file_get_contents("php://input"), true);

$stmt = $pdo->prepare("INSERT INTO focus_sessions (user_id, task, task_type, focused, unfocused, score, timestamp)
                       VALUES (?, ?, ?, ?, ?, ?, NOW())");

$stmt->execute([
  $_SESSION['user_id'],
  $data['task'],
  $data['type'],
  $data['focused'],
  $data['unfocused'],
  $data['score']
]);

echo "Session saved.";
?>
