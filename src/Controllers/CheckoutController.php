<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Controllers\Controller;
use App\Database\Connection;
use App\Repositories\MenuRepository;
use App\Repositories\OrderRepository;
use App\Services\CartService;
use App\Services\Logger;
use App\Services\Validator;

class CheckoutController extends Controller
{
  public function index(): void
  {
    $basePath = dirname(__DIR__, 2);
    $config = require $basePath . '/config/app.php';
    $cartService = new CartService(new MenuRepository(), $config);

    $cart = $cartService->hydrateCart($_SESSION['cart'] ?? []);
    $totals = $cartService->calculateTotals($cart);
    $this->render('checkout', [
      'title' => 'Checkout',
      'cart' => $cart,
      'totals' => $totals,
      'error' => null,
      'errors' => [],
      'old' => []
    ]);
  }

  public function place(): void
  {
    $basePath = dirname(__DIR__, 2);
    $config = require $basePath . '/config/app.php';
    $cartService = new CartService(new MenuRepository(), $config);

    if (!csrf_verify($_POST['csrf_token'] ?? '')) {
      http_response_code(400);
      Logger::warning('Checkout: CSRF verification failed');

      $cart = $cartService->hydrateCart($_SESSION['cart'] ?? []);
      $totals = $cartService->calculateTotals($cart);

      $this->render('checkout', [
        'title' => 'Checkout',
        'cart' => $cart,
        'totals' => $totals,
        'error' => 'csrf',
        'errors' => [],
        'old' => $_POST
      ]);
      return;
    }

    $cart = $_SESSION['cart'] ?? [];
    if (!$cart) {
      Logger::warning('Checkout: empty cart on place order');
      $this->render('checkout', [
        'title' => 'Checkout',
        'cart' => [],
        'totals' => ['subtotal' => 0, 'tax' => 0, 'total' => 0],
        'error' => 'empty_cart',
        'errors' => [],
        'old' => []
      ]);
      return;
    }

    // Validate input using Validator service
    $validator = new Validator();
    $isValid = $validator->validate($_POST, [
      'name' => 'required|min:2',
      'email' => 'required|email',
      'phone' => 'required|phone',
      'address' => 'required|min:10'
    ]);

    if (!$isValid) {
      Logger::warning('Checkout: validation failed', ['errors' => $validator->errors()]);

      $hydratedCart = $cartService->hydrateCart($cart);
      $totals = $cartService->calculateTotals($hydratedCart);

      $this->render('checkout', [
        'title' => 'Checkout',
        'cart' => $hydratedCart,
        'totals' => $totals,
        'errors' => $validator->errors(),
        'old' => $_POST
      ]);
      return;
    }

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    // Build detailed items from cart
    $repoMenu = new MenuRepository();
    $menu = $repoMenu->getMenu();
    $itemsById = [];
    foreach (($menu['itemsByCategory'] ?? []) as $items) {
      foreach ($items as $item) {
        $itemsById[(int) $item['id']] = $item;
      }
    }
    $orderItems = [];
    foreach ($cart as $id => $qty) {
      $id = (int) $id;
      $qty = (int) $qty;
      if (!isset($itemsById[$id])) {
        continue;
      }
      $item = $itemsById[$id];
      $orderItems[] = [
        'id' => $id,
        'name' => $item['name'],
        'price' => (float) $item['price'],
        'quantity' => $qty,
      ];
    }

    // Persist order and items
    $repoOrder = new OrderRepository();
    $orderId = $repoOrder->create(['name' => $name, 'email' => $email, 'phone' => $phone, 'address' => $address]);
    $repoOrder->addItems($orderId, $orderItems);
    Logger::info('Checkout: order created', ['order_id' => $orderId, 'items' => count($orderItems)]);

    unset($_SESSION['cart']);
    $this->render('checkout_success', ['title' => 'Order Placed', 'orderId' => $orderId]);
  }
}
