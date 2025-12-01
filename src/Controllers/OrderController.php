<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Controllers\Controller;
use App\Repositories\MenuRepository;

class OrderController extends Controller
{
  public function index(): void
  {
    $repo = new MenuRepository();
    $menu = $repo->getMenu();

    // Flatten items for order page (ordered by category)
    $items = [];
    foreach (($menu['itemsByCategory'] ?? []) as $category => $categoryItems) {
      foreach ($categoryItems as $item) {
        $items[] = $item;
      }
    }

    $error = $_SESSION['error'] ?? null;
    unset($_SESSION['error']);
    $this->render('order', [
      'title' => 'Order Online',
      'items' => $items,
    ]);
  }

  public function add(): void
  {
    if (!csrf_verify($_POST['csrf_token'] ?? '')) {
      http_response_code(400);
      $_SESSION['error'] = 'invalid_csrf';
      header('Location: ' . base_url('/order'));
      exit;
    }

    if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
      $_SESSION['cart'] = [];
    }

    $itemId = (int) ($_POST['item_id'] ?? 0);
    $qty = max(1, (int) ($_POST['quantity'] ?? 1));

    if ($itemId <= 0) {
      $_SESSION['error'] = 'invalid_item';
      header('Location: ' . base_url('/order'));
      exit;
    }

    // Ensure cart item is integer, not array
    $currentQty = isset($_SESSION['cart'][$itemId]) && is_int($_SESSION['cart'][$itemId])
      ? $_SESSION['cart'][$itemId]
      : 0;

    $_SESSION['cart'][$itemId] = $currentQty + $qty;

    header('Location: ' . base_url('/cart'));
    exit;
  }
}
