<?php
$servername = "localhost";
$database = "tokyo_bloom";
$username = "root";
$password = "";

try {
  $conn = new PDO(dsn: "mysql:host=$servername; dbname=$database", username: $username, password: $password);
  // set the PDO error mode to exception
  $conn->setAttribute(attribute: PDO::ATTR_ERRMODE, value: PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
?>