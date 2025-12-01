<?php
declare(strict_types=1);

namespace App\Database;

use PDO;
use PDOException;

class Connection
{
  public static function make(): PDO
  {
    $host = $_ENV['DB_HOST'] ?? 'localhost';
    $db = $_ENV['DB_NAME'] ?? 'tokyo_bloom';
    $user = $_ENV['DB_USER'] ?? 'root';
    $pass = $_ENV['DB_PASS'] ?? '';
    $charset = $_ENV['DB_CHARSET'] ?? 'utf8mb4';

    $dsn = "mysql:host={$host};dbname={$db};charset={$charset}";
    $options = [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      PDO::ATTR_EMULATE_PREPARES => false,
    ];

    try {
      return new PDO($dsn, $user, $pass, $options);
    } catch (PDOException $e) {
      http_response_code(500);
      echo 'Database connection failed.';
      exit;
    }
  }
}
