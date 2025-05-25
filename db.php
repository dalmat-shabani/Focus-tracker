<?php
$host = 'localhost';
$db   = 'focus_tracker';
$user = 'root';
$pass = ''; // XAMPP default
$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

$options = [
  PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
  $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
  exit("Database connection failed: " . $e->getMessage());
}
?>
