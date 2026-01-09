<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Database\Connection;
use PDO;

class MenuRepository
{
  public function __construct(private ?PDO $pdo = null)
  {
    $this->pdo = $pdo ?: Connection::make();
  }

  public function getMenu(): array
  {
    $stmt = $this->pdo->query('SELECT * FROM menu_items ORDER BY category, name');
    $rows = $stmt->fetchAll();

    $categories = [];
    $itemsByCategory = [];

    foreach ($rows as $row) {
      $cat = (string) $row['category'];
      if (!in_array($cat, $categories, true)) {
        $categories[] = $cat;
      }
      $itemsByCategory[$cat] ??= [];
      $itemsByCategory[$cat][] = $row;
    }

    return [
      'categories' => $categories,
      'itemsByCategory' => $itemsByCategory,
    ];
  }
}
