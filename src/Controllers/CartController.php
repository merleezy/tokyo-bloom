<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Controllers\Controller;
use App\Services\Logger;
use App\Services\CartService;
use App\Repositories\MenuRepository;

class CartController extends Controller
{
  public function index(): void
  {
    $cart = $_SESSION['cart'] ?? [];
    
    $basePath = dirname(__DIR__, 2);
    $config = require $basePath . '/config/app.php';
    
    $cartService = new CartService(new MenuRepository(), $config);
    
    $detailed = $cartService->hydrateCart($cart);
    $totals = $cartService->calculateTotals($detailed);
    
    $this->render('cart', [
      'title' => 'Your Cart',
      'cart' => $detailed,
      'totals' => $totals,
    ]);
  }

  public function update(): void
  {
    if (!csrf_verify($_POST['csrf_token'] ?? '')) {
      http_response_code(400);
      Logger::warning('Cart: CSRF verification failed on update');
      $this->render('cart', ['title' => 'Your Cart', 'error' => 'invalid_csrf', 'cart' => $_SESSION['cart'] ?? []]);
      return;
    }
    $updates = $_POST['quantity'] ?? [];
    $_SESSION['cart'] = $_SESSION['cart'] ?? [];
    foreach ($updates as $itemId => $qty) {
      $itemId = (int) $itemId;
      $qty = max(0, (int) $qty);
      if ($qty === 0) {
        unset($_SESSION['cart'][$itemId]);
        Logger::info('Cart: item removed via update', ['item_id' => $itemId]);
      } else {
        $_SESSION['cart'][$itemId] = $qty;
        Logger::info('Cart: quantity updated', ['item_id' => $itemId, 'quantity' => $qty]);
      }
    }
    header('Location: ' . base_url('/cart'));
    exit;
  }

  public function remove(): void
  {
    if (!csrf_verify($_POST['csrf_token'] ?? '')) {
      http_response_code(400);
      Logger::warning('Cart: CSRF verification failed on remove');
      $this->render('cart', ['title' => 'Your Cart', 'error' => 'invalid_csrf', 'cart' => $_SESSION['cart'] ?? []]);
      return;
    }
    $itemId = (int) ($_POST['item_id'] ?? 0);
    if (isset($_SESSION['cart'][$itemId])) {
      unset($_SESSION['cart'][$itemId]);
      Logger::info('Cart: item removed', ['item_id' => $itemId]);
    }
    header('Location: ' . base_url('/cart'));
    exit;
  }

  public function clear(): void
  {
    if (!csrf_verify($_POST['csrf_token'] ?? '')) {
      http_response_code(400);
      Logger::warning('Cart: CSRF verification failed on clear');
      $this->render('cart', ['title' => 'Your Cart', 'error' => 'invalid_csrf', 'cart' => $_SESSION['cart'] ?? []]);
      return;
    }
    unset($_SESSION['cart']);
    Logger::info('Cart: cleared');
    header('Location: ' . base_url('/cart'));
    exit;
  }
}
