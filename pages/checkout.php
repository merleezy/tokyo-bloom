<?php
session_start();

// Calculate total in case you want to show it here
$total = 0;
if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['price'] * $item['quantity'];
    }
}

$orderPlaced = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // In a real app you'd save order to DB here
    $orderPlaced = true;
    $_SESSION['cart'] = []; // clear cart
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Checkout | Tokyo Bloom</title>
  <link rel="stylesheet" href="../css/style.css">
  <script src="../js/scripts.js"></script>
</head>
<body id="top">
  <header id="site-header">
    <a href="index.html"><img src="../images/tokyo_bloom_logo.png" alt="Tokyo Bloom Logo" id="site-logo"></a>
    <nav id="nav-bar">
      <ul>
        <li><a href="index.html">Home</a></li>
        <li><a href="menu.php">Menu</a></li>
        <li><a href="order.php" aria-current="page">Order Online</a></li>
        <li><a href="reservations.php">Reservations</a></li>
        <li><a href="contact.html">Contact</a></li>
      </ul>
    </nav>
  </header>

  <main>
    <section class="page-banner dynamic-hero">
      <h1>Checkout</h1>
    </section>

    <section id="checkout-section">
      <?php if ($orderPlaced): ?>
        <h2>Thank you!</h2>
        <p>Your order has been placed. We’ll begin preparing it right away.</p>
        <p><a href="order.php" class="button-link">Back to Order Online</a></p>
      <?php else: ?>
        <?php if (empty($_SESSION['cart'])): ?>
          <p>Your cart is empty.</p>
          <p><a href="order.php" class="button-link">Browse the menu and add some items.</a></p>
        <?php else: ?>
          <p>Your total is <strong>$<?= number_format($total, 2) ?></strong>.</p>
          <p>Confirm your order below.</p>
          <form action="checkout.php" method="post">
            <button type="submit" class="button-link">Place Order</button>
          </form>
        <?php endif; ?>
      <?php endif; ?>
    </section>
  </main>

  <footer id="site-footer">
    <p>&copy; 2025 Tokyo Bloom Sushi and Grill. All rights reserved.</p>
  </footer>
</body>
</html>
