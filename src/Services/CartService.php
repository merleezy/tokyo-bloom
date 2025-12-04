<?php
declare(strict_types=1);

namespace App\Services;

use App\Repositories\MenuRepository;

class CartService
{
  private MenuRepository $menuRepository;
  private float $taxRate;

  public function __construct(MenuRepository $menuRepository, array $config = [])
  {
    $this->menuRepository = $menuRepository;
    // Fallback to 0.10 if not configured
    $this->taxRate = (float)($config['tax_rate'] ?? 0.10);
  }

  public function hydrateCart(array $sessionCart): array
  {
    if (empty($sessionCart)) {
      return [];
    }

    $menu = $this->menuRepository->getMenu();
    $itemsById = [];
    foreach (($menu['itemsByCategory'] ?? []) as $items) {
      foreach ($items as $item) {
        $itemsById[(int) $item['id']] = $item;
      }
    }

    $detailed = [];
    foreach ($sessionCart as $id => $qty) {
      $id = (int) $id;
      $qty = (int) $qty;
      if (!isset($itemsById[$id]) || $qty < 1) {
        continue;
      }
      $item = $itemsById[$id];
      $detailed[] = [
        'id' => $id,
        'name' => $item['name'],
        'price' => (float) $item['price'],
        'quantity' => $qty,
        'subtotal' => (float) $item['price'] * $qty,
      ];
    }
    return $detailed;
  }

  public function calculateTotals(array $detailedCart): array
  {
    $subtotal = 0.0;
    foreach ($detailedCart as $row) {
      $subtotal += (float) $row['subtotal'];
    }
    
    $tax = $subtotal * $this->taxRate;
    $total = $subtotal + $tax;

    return [
      'subtotal' => $subtotal,
      'tax' => $tax,
      'total' => $total
    ];
  }
}