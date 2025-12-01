<?php
declare(strict_types=1);

use App\Controllers\HomeController;
use App\Controllers\MenuController;
use App\Controllers\ReservationsController;
use App\Controllers\ContactController;
use App\Controllers\OrderController;
use App\Controllers\CartController;
use App\Controllers\CheckoutController;

return [
  ['GET', '/', [HomeController::class, 'index']],
  ['GET', '/menu', [MenuController::class, 'index']],
  ['GET', '/reservations', [ReservationsController::class, 'index']],
  ['POST', '/reservations', [ReservationsController::class, 'store']],
  ['GET', '/reservations/confirm', [ReservationsController::class, 'confirm']],
  ['POST', '/reservations/cancel', [ReservationsController::class, 'cancel']],
  ['GET', '/contact', [ContactController::class, 'index']],
  ['POST', '/contact', [ContactController::class, 'send']],
  ['GET', '/contact/success', [ContactController::class, 'success']],
  // Order & Cart & Checkout
  ['GET', '/order', [OrderController::class, 'index']],
  ['POST', '/order/add', [OrderController::class, 'add']],
  ['GET', '/cart', [CartController::class, 'index']],
  ['POST', '/cart/update', [CartController::class, 'update']],
  ['POST', '/cart/remove', [CartController::class, 'remove']],
  ['POST', '/cart/clear', [CartController::class, 'clear']],
  ['GET', '/checkout', [CheckoutController::class, 'index']],
  ['POST', '/checkout', [CheckoutController::class, 'place']],
];
