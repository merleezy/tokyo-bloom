<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Database\Connection;
use PDO;

class OrderRepository
{
  public function create(array $customer): int
  {
    $pdo = Connection::make();
    $stmt = $pdo->prepare('INSERT INTO orders (customer_name, customer_email, customer_phone, customer_address, created_at) VALUES (?, ?, ?, ?, NOW())');
    $stmt->execute([
      $customer['name'] ?? '',
      $customer['email'] ?? '',
      $customer['phone'] ?? '',
      $customer['address'] ?? '',
    ]);
    return (int) $pdo->lastInsertId();
  }

  public function addItems(int $orderId, array $items): void
  {
    if (!$items) {
      return;
    }
    $pdo = Connection::make();
    $stmt = $pdo->prepare('INSERT INTO order_items (order_id, item_id, name, price, quantity) VALUES (?, ?, ?, ?, ?)');
    foreach ($items as $item) {
      $stmt->execute([
        $orderId,
        (int) $item['id'],
        $item['name'],
        (float) $item['price'],
        (int) $item['quantity'],
      ]);
    }
  }
}
