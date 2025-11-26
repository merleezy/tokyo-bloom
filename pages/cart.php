<?php
session_start();
require '../dbconnect.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        $id       = (int)($_POST['id'] ?? 0);
        $quantity = max(1, (int)($_POST['quantity'] ?? 1));

        if ($id > 0) {
            // Always look up item data from DB to avoid mismatches
            $stmt = $conn->prepare("SELECT id, name, price FROM menu_items WHERE id = :id");
            $stmt->execute([':id' => $id]);
            $item = $stmt->fetch();

            if ($item) {
                if (!isset($_SESSION['cart'][$id])) {
                    $_SESSION['cart'][$id] = [
                        'name'     => $item['name'],
                        'price'    => (float)$item['price'],
                        'quantity' => 0,
                    ];
                }
                $_SESSION['cart'][$id]['quantity'] += $quantity;
            }
        }

    } elseif ($action === 'update') {
        if (!empty($_POST['quantities']) && is_array($_POST['quantities'])) {
            foreach ($_POST['quantities'] as $id => $qty) {
                $id  = (int)$id;
                $qty = (int)$qty;
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
    $removeId = (int)$_GET['remove'];
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
        <p>Your cart is currently empty.</p>
        <p><a href="order.php">Browse the menu and add some items.</a></p>
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
                  <td><?= htmlspecialchars($item['name']) ?></td>
                  <td>$<?= number_format($item['price'], 2) ?></td>
                  <td>
                    <input type="number" name="quantities[<?= $id ?>]" value="<?= $item['quantity'] ?>" min="0">
                  </td>
                  <td>$<?= number_format($subtotal, 2) ?></td>
                  <td><a href="cart.php?remove=<?= $id ?>">Remove</a></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>

          <p class="cart-total"><strong>Total:</strong> $<?= number_format($total, 2) ?></p>

          <div class="cart-actions">
            <button type="submit">Update Cart</button>
          </div>
        </form>

        <form action="cart.php" method="post" style="display:inline-block; margin-right:1rem;">
          <input type="hidden" name="action" value="clear">
          <button type="submit">Clear Cart</button>
        </form>

        <a href="checkout.php" class="button-link">Proceed to Checkout</a>
      <?php endif; ?>
    </section>
  </main>

  <footer id="site-footer">
    <p>&copy; 2025 Tokyo Bloom Sushi and Grill. All rights reserved.</p>
  </footer>
</body>
</html>
