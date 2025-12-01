<?php
session_start();
require '../dbconnect.php';

if (!isset($_SESSION['cart'])) {
  $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $action = $_POST['action'] ?? '';

  if ($action === 'add') {
    $id = (int) ($_POST['id'] ?? 0);
    $quantity = max(1, (int) ($_POST['quantity'] ?? 1));

    if ($id > 0) {
      // Always look up item data from DB to avoid mismatches
      $stmt = $conn->prepare("SELECT id, name, price FROM menu_items WHERE id = :id");
      $stmt->execute([':id' => $id]);
      $item = $stmt->fetch();

      if ($item) {
        if (!isset($_SESSION['cart'][$id])) {
          $_SESSION['cart'][$id] = [
            'name' => $item['name'],
            'price' => (float) $item['price'],
            'quantity' => 0,
          ];
        }
        $_SESSION['cart'][$id]['quantity'] += $quantity;
      }
    }

  } elseif ($action === 'update') {
    if (!empty($_POST['quantities']) && is_array($_POST['quantities'])) {
      foreach ($_POST['quantities'] as $id => $qty) {
        $id = (int) $id;
        $qty = (int) $qty;
        if ($qty <= 0) {
          unset($_SESSION['cart'][$id]);
        } else {
          if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity'] = $qty;
          }
        }
      }
    }

  } elseif ($action === 'clear') {
    $_SESSION['cart'] = [];
  }
}

if (isset($_GET['remove'])) {
  $removeId = (int) $_GET['remove'];
  unset($_SESSION['cart'][$removeId]);
}

$total = 0;
foreach ($_SESSION['cart'] as $id => $item) {
  $total += $item['price'] * $item['quantity'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Your Cart | Tokyo Bloom</title>
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
      <h1>Your Cart</h1>
    </section>

    <section id="cart-section">
      <?php if (empty($_SESSION['cart'])): ?>
        <div id="checkout-section">
          <h2>Your Cart is Empty</h2>
          <p>Looks like you haven't added any items to your cart yet.</p>
          <a href="order.php" class="button-link">Browse Menu</a>
        </div>
      <?php else: ?>
        <form action="cart.php" method="post">
          <input type="hidden" name="action" value="update">

          <table class="cart-table">
            <thead>
              <tr>
                <th>Item</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($_SESSION['cart'] as $id => $item):
                $subtotal = $item['price'] * $item['quantity'];
                ?>
                <tr>
                  <td data-label="Item"><?= htmlspecialchars($item['name']) ?></td>
                  <td data-label="Price">$<?= number_format($item['price'], 2) ?></td>
                  <td data-label="Quantity">
                    <input type="number" name="quantities[<?= $id ?>]" value="<?= $item['quantity'] ?>" min="0">
                  </td>
                  <td data-label="Subtotal">$<?= number_format($subtotal, 2) ?></td>
                  <td data-label="Action"><a href="cart.php?remove=<?= $id ?>"
                      style="color: #C91818; text-decoration: underline;">Remove</a></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>

          <p class="cart-total"><strong>Total:</strong> $<?= number_format($total, 2) ?></p>

          <div class="cart-actions">
            <button type="submit">Update Cart</button>
            <a href="order.php" class="button-link">Continue Shopping</a>
          </div>
        </form>

        <div class="cart-actions" style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 2px solid #E0E0E0;">
          <a href="checkout.php" class="button-link" style="font-size: 1.05rem; padding: 0.7rem 1.5rem;">Proceed to
            Checkout</a>

          <form action="cart.php" method="post" style="display:inline-block; margin-left:1rem;">
            <input type="hidden" name="action" value="clear">
            <button type="submit" style="background-color: #666; font-size: 0.9rem;">Clear Cart</button>
          </form>
        </div>
      <?php endif; ?>
    </section>
  </main>

  <footer id="site-footer">
    <div class="footer-content">
      <div class="footer-section">
        <h3>Tokyo Bloom</h3>
        <p>Authentic Japanese cuisine<br>in the heart of the city</p>
      </div>

      <div class="footer-section">
        <h3>Location</h3>
        <p>123 Sakura Boulevard<br>
          Downtown District<br>
          San Francisco, CA 94102</p>
      </div>

      <div class="footer-section">
        <h3>Contact</h3>
        <p>Phone: (415) 555-SUSHI<br>
          Email: info@tokyobloom.com</p>
      </div>

      <div class="footer-section">
        <h3>Hours</h3>
        <p>Mon-Fri: 11am - 10pm<br>
          Sat: 5pm - 11pm<br>
          Sun: Closed</p>
      </div>
    </div>

    <div class="footer-bottom">
      <p>&copy; 2025 Tokyo Bloom Sushi and Grill. All rights reserved.</p>
    </div>
  </footer>
</body>

</html>