<?php
require '../dbconnect.php';

$stmt = $conn->query("SELECT * FROM menu_items ORDER BY category, name");
$items = $stmt->fetchAll();
$currentCategory = '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Menu | Tokyo Bloom</title>
  <link rel="stylesheet" href="../css/style.css">
  <script src="../js/scripts.js"></script>
</head>

<body id="top">
  <header id="site-header">
    <a href="#top"><img src="../images/tokyo_bloom_logo.png" alt="Tokyo Bloom Logo" id="site-logo"></a>
    <nav id="nav-bar">
      <ul>
        <li><a href="index.html">Home</a></li>
        <li><a href="#top" aria-current="page">Menu</a></li>
        <li><a href="order.php">Order Online</a></li>
        <li><a href="reservations.php">Reservations</a></li>
        <li><a href="contact.html">Contact</a></li>
      </ul>
    </nav>
  </header>

  <main>
    <section class="page-banner dynamic-hero">
      <h1>Menu</h1>
    </section>
    <section id="menu-section">
      <h2>Our Menu</h2>
      <p>Explore our selection of authentic Japanese cuisine, crafted with the finest ingredients.</p>

      <?php foreach ($items as $item): ?>

        <?php if ($item['category'] !== $currentCategory): ?>
          <?php
          $currentCategory = $item['category'];
          echo "<h2 class='menu-category'>{$currentCategory}</h2>";
          ?>
        <?php endif; ?>

        <div class="menu-item">
          <?php if (!empty($item['image_url'])): ?>
            <img src="../<?= htmlspecialchars($item['image_url']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
          <?php endif; ?>

          <div class="menu-item-info">
            <h3>
              <?= htmlspecialchars($item['name']) ?>
              <span class="menu-price">$<?= number_format($item['price'], 2) ?></span>
            </h3>
            <p><?= htmlspecialchars($item['description']) ?></p>
          </div>
        </div>

      <?php endforeach; ?>

      <div class="cart-actions"
        style="text-align: center; margin-top: 2.5rem; padding-top: 2rem; border-top: 2px solid #E0E0E0;">
        <p style="margin-bottom: 1rem; font-size: 1.1rem;">Ready to order?</p>
        <a href="order.php" class="button-link" style="font-size: 1.05rem; padding: 0.7rem 1.5rem;">Order Online</a>
      </div>
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