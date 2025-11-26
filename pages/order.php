<?php
session_start();
require '../dbconnect.php';

// get all menu items ordered by category then name
$stmt = $conn->query("SELECT * FROM menu_items ORDER BY category, name");
$items = $stmt->fetchAll();
$currentCategory = '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order Online | Tokyo Bloom</title>
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
      <h1>Order Online</h1>
    </section>

    <section id="order-section">
      <p>Select your favorite dishes and add them to your cart.</p>

      <?php foreach ($items as $item): ?>

        <?php if ($item['category'] !== $currentCategory): ?>
          <?php 
            $currentCategory = $item['category'];
            echo "<h2 class=\"menu-category\">{$currentCategory}</h2>";
          ?>
        <?php endif; ?>

        <div class="menu-item">
          <?php if (!empty($item['image_url'])): ?>
            <img src="../<?= htmlspecialchars($item['image_url']) ?>" 
                 alt="<?= htmlspecialchars($item['name']) ?>">
          <?php endif; ?>

          <div class="menu-item-info">
            <h3>
              <?= htmlspecialchars($item['name']) ?>
              <span class="menu-price">$<?= number_format($item['price'], 2) ?></span>
            </h3>
            <p><?= htmlspecialchars($item['description']) ?></p>

            <form action="cart.php" method="post" class="add-to-cart-form">
              <input type="hidden" name="action" value="add">
              <input type="hidden" name="id" value="<?= (int)$item['id'] ?>">

              <label for="qty-<?= (int)$item['id'] ?>">Qty:</label>
              <input type="number" id="qty-<?= (int)$item['id'] ?>" name="quantity" value="1" min="1">

              <button type="submit">Add to Cart</button>
            </form>
          </div>
        </div>

      <?php endforeach; ?>

      <p style="margin-top: 1.5rem;">
        <a href="cart.php">View Cart</a>
      </p>
    </section>
  </main>

  <footer id="site-footer">
    <p>&copy; 2025 Tokyo Bloom Sushi and Grill. All rights reserved.</p>
  </footer>
</body>
</html>