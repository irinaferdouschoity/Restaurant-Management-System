<?php
// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = 'localhost:3307';  // ← ADD PORT 3307 HERE
$dbname = 'restaurant_system';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>