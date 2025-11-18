<?php
require_once 'dbconnect.php';

// header("Content-Type: application/json; charset=UTF-8");

$query = "SELECT * FROM products";

try {
    $stmt = $conn->query($query);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($results);
} catch (PDOException $e) {
    echo "Query failed: " . $e->getMessage();
}

?>