<?php
// Run this file to create orders and order_items tables
require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->safeLoad();

$host = $_ENV['DB_HOST'] ?? 'localhost';
$db = $_ENV['DB_DATABASE'] ?? 'tokyo_bloom';
$user = $_ENV['DB_USERNAME'] ?? 'root';
$pass = $_ENV['DB_PASSWORD'] ?? '';

try {
  $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $sql = file_get_contents(__DIR__ . '/migrations/001_create_orders_tables.sql');
  $pdo->exec($sql);

  echo "✓ Migration completed successfully!\n";
  echo "✓ Created tables: orders, order_items\n";
} catch (PDOException $e) {
  echo "✗ Error: " . $e->getMessage() . "\n";
  exit(1);
}
