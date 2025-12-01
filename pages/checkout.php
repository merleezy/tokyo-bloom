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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout | Tokyo Bloom</title>
  <link rel="stylesheet" href="../css/style.css">
  <script src="../js/scripts.js"></script>
  <link rel="icon" href="../images/tokyo_bloom_icon.png" type="image/png">
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
        <div id="reservation-section-page" style="margin: 2rem auto;">
          <h2>Order Confirmed!</h2>
          <p style="font-size: 1.1rem; margin: 1.5rem 0;">Thank you for your order! We'll begin preparing your delicious
            meal right away.</p>
          <p>You will receive a confirmation shortly.</p>
          <div style="margin-top: 2rem; display: flex; gap: 1rem; flex-wrap: wrap; justify-content: center;">
            <a href="order.php" class="button-link"
              style="background-color: #C91818; flex: 1 1 200px; text-align: center;">Order Again</a>
            <a href="index.html" class="button-link"
              style="background-color: #666; flex: 1 1 200px; text-align: center;">Back to Home</a>
          </div>
        </div>
      <?php else: ?>
        <?php if (empty($_SESSION['cart'])): ?>
          <div id="reservation-section-page" style="margin: 2rem auto;">
            <h2>Your Cart is Empty</h2>
            <p>You need to add items to your cart before checking out.</p>
            <div style="margin-top: 1.5rem;">
              <a href="order.php" class="button-link">Browse Menu</a>
            </div>
          </div>
        <?php else: ?>
          <div id="reservation-section-page" style="margin: 2rem auto;">
            <h2>Complete Your Order</h2>
            <p>Review your order and provide delivery details below.</p>

            <!-- Order Summary -->
            <div
              style="background-color: rgba(255,255,255,0.1); border-radius: 8px; padding: 1.5rem; margin: 2rem 0; text-align: left;">
              <h3 style="margin-top: 0; color: #F5B7C3; font-size: 1.2rem;">Order Summary</h3>
              <?php foreach ($_SESSION['cart'] as $item): ?>
                <div
                  style="display: flex; justify-content: space-between; padding: 0.5rem 0; border-bottom: 1px solid rgba(255,255,255,0.2);">
                  <span><?= htmlspecialchars($item['name']) ?> × <?= $item['quantity'] ?></span>
                  <span>$<?= number_format($item['price'] * $item['quantity'], 2) ?></span>
                </div>
              <?php endforeach; ?>
              <div
                style="display: flex; justify-content: space-between; padding: 1rem 0 0; font-weight: 700; font-size: 1.2rem; color: #F5B7C3;">
                <span>Total:</span>
                <span>$<?= number_format($total, 2) ?></span>
              </div>
            </div>

            <form action="checkout.php" method="post">
              <div id="info-container">
                <div id="personal-info">
                  <label for="name">Full Name:</label>
                  <input type="text" id="name" name="name" required>

                  <label for="email">Email:</label>
                  <input type="email" id="email" name="email" required>

                  <label for="phone">Phone Number:</label>
                  <input type="tel" id="phone" name="phone" required>
                </div>

                <div id="reservation-info">
                  <label for="address">Delivery Address:</label>
                  <textarea id="address" name="address" rows="3" required></textarea>

                  <label for="notes">Special Instructions (Optional):</label>
                  <textarea id="notes" name="notes" rows="3" placeholder="Allergies, preferences, etc."></textarea>
                </div>
              </div>

              <button type="submit"
                style="width: 100%; max-width: 100%; padding: 12px 0; background-color: #C91818; color: #FFFFFF; border: none; border-radius: 6px; margin-top: 1em; cursor: pointer; transition: 0.3s ease; font-size: 1rem; font-weight: 600;">Place
                Order ($<?= number_format($total, 2) ?>)</button>
            </form>

            <div style="margin-top: 1.5rem;">
              <a href="cart.php" style="color: #F5B7C3; text-decoration: underline;">← Back to Cart</a>
            </div>
          </div>
        <?php endif; ?>
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