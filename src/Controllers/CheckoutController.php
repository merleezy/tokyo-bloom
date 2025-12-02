<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Controllers\Controller;
use App\Database\Connection;
use App\Repositories\MenuRepository;
use App\Repositories\OrderRepository;
use App\Services\Logger;
use App\Services\Validator;

class CheckoutController extends Controller
{
  public function index(): void
  {
    $cart = $this->hydrateCart($_SESSION['cart'] ?? []);
    $totals = $this->calculateTotals($cart);
    $this->render('checkout', [
      'title' => 'Checkout',
      'cart' => $cart,
      'totals' => $totals,
      'error' => null,
      'errors' => [],
      'old' => []
    ]);
  }

  private function hydrateCart(array $sessionCart): array
  {
    $repoMenu = new MenuRepository();
    $menu = $repoMenu->getMenu();
    $itemsById = [];
    foreach (($menu['itemsByCategory'] ?? []) as $items) {
      foreach ($items as $item) {
        $itemsById[(int) $item['id']] = $item;
      }
    }
    $hydrated = [];
    foreach ($sessionCart as $id => $qty) {
      $id = (int) $id;
      $qty = (int) $qty;
      if (!isset($itemsById[$id]) || $qty < 1) {
        continue;
      }
      $item = $itemsById[$id];
      $hydrated[] = [
        'id' => $id,
        'name' => $item['name'],
        'price' => (float) $item['price'],
        'quantity' => $qty,
        'subtotal' => (float) $item['price'] * $qty,
      ];
    }
    return $hydrated;
  }

  private function calculateTotals(array $cart): array
  {
    $subtotal = 0.0;
    foreach ($cart as $row) {
      $subtotal += (float) $row['subtotal'];
    }
    $tax = $subtotal * 0.10;
    $total = $subtotal + $tax;
    return ['subtotal' => $subtotal, 'tax' => $tax, 'total' => $total];
  }

  public function place(): void
  {
    if (!csrf_verify($_POST['csrf_token'] ?? '')) {
      http_response_code(400);
      Logger::warning('Checkout: CSRF verification failed');

      $cart = $this->hydrateCart($_SESSION['cart'] ?? []);
      $totals = $this->calculateTotals($cart);

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

      $hydratedCart = $this->hydrateCart($cart);
      $totals = $this->calculateTotals($hydratedCart);

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
