<?php $pageTitle = $title ?? 'Order Online'; ?>
  <header id="site-header">
  <a href="<?php echo base_url('/'); ?>#top"><img src="<?php echo asset_url('images/tokyo_bloom_logo.png'); ?>" alt="Tokyo Bloom Logo" id="site-logo"></a>
  <nav id="nav-bar">
    <ul>
      <li><a href="<?php echo base_url('/'); ?>">Home</a></li>
      <li><a href="<?php echo base_url('/menu'); ?>">Menu</a></li>
      <li><a href="<?php echo base_url('/order'); ?>" aria-current="page">Order Online</a></li>
      <li><a href="<?php echo base_url('/reservations'); ?>">Reservations</a></li>
      <li><a href="<?php echo base_url('/contact'); ?>">Contact</a></li>
    </ul>
  </nav>
</header>

<main>
  <section class="page-banner dynamic-hero">
    <h1>Order Online</h1>
  </section>

  <section id="order-section">
    <h2>Browse Our Menu</h2>
    <p>Select your favorite dishes and add them to your cart. All items are freshly prepared to order.</p>

    <?php if (!empty($error) && $error === 'invalid_item'): ?>
      <p class="error">Please choose a valid item.</p>
    <?php endif; ?>

    <?php 
    $currentCategory = '';
    foreach (($items ?? []) as $item):
      if ($item['category'] !== $currentCategory):
        $currentCategory = $item['category'];
        echo '<h2 class="menu-category">' . htmlspecialchars($currentCategory, ENT_QUOTES, 'UTF-8') . '</h2>';
      endif;
    ?>
      <div class="menu-item">
        <?php if (!empty($item['image_url'])): ?>
          <img src="<?php echo asset_url(htmlspecialchars($item['image_url'], ENT_QUOTES, 'UTF-8')); ?>" alt="<?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?>" loading="lazy">
        <?php endif; ?>

        <div class="menu-item-info">
          <h3>
            <?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?>
            <span class="menu-price">$<?php echo number_format((float)$item['price'], 2); ?></span>
          </h3>
          <p><?php echo htmlspecialchars($item['description'] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>

          <form action="<?php echo base_url('/order/add'); ?>" method="post" class="add-to-cart-form">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="item_id" value="<?php echo (int)$item['id']; ?>">

            <label for="qty-<?php echo (int)$item['id']; ?>">Qty:</label>
            <input type="number" id="qty-<?php echo (int)$item['id']; ?>" name="quantity" value="1" min="1">

            <button type="submit">Add to Cart</button>
          </form>
        </div>
      </div>
    <?php endforeach; ?>

    <div class="cart-actions" style="text-align: center; margin-top: 2rem;">
      <a href="<?php echo base_url('/cart'); ?>" class="button-link">View Cart & Checkout</a>
    </div>
  </section>

  <footer id="site-footer">
    <div class="footer-content">
      <div class="footer-section">
        <h3>Tokyo Bloom</h3>
        <p>Authentic Japanese cuisine<br>in the heart of the city</p>
      </div>
      <div class="footer-section">
        <h3>Location</h3>
        <p>123 Sakura Boulevard<br>Downtown District<br>San Francisco, CA 94102</p>
      </div>
      <div class="footer-section">
        <h3>Contact</h3>
        <p>Phone: (415) 555-SUSHI<br>Email: info@tokyobloom.com</p>
      </div>
      <div class="footer-section">
        <h3>Hours</h3>
        <p>Mon-Fri: 11am - 10pm<br>Sat: 5pm - 11pm<br>Sun: Closed</p>
      </div>
    </div>
    <div class="footer-bottom">
      <p>&copy; 2025 Tokyo Bloom Sushi and Grill. All rights reserved.</p>
    </div>
  </footer>
</main>
