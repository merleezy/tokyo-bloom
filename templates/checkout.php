<?php $pageTitle = $title ?? 'Checkout'; ?>
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
    <h1>Checkout</h1>
  </section>

  <section id="checkout-section">
    <?php if (!empty($error)): ?>
      <p class="error">
        <?php 
          if ($error === 'invalid_csrf') echo 'Session expired. Please try again.';
          elseif ($error === 'empty_cart') echo 'Your cart is empty. Please add items before checking out.';
          else echo 'Please complete all required fields correctly.';
        ?>
      </p>
    <?php endif; ?>

    <?php if (empty($cart)): ?>
      <div id="reservation-section-page" style="margin: 2rem auto;">
        <h2>Your Cart is Empty</h2>
        <p>You need to add items to your cart before checking out.</p>
        <div style="margin-top: 1.5rem;">
          <a href="<?php echo base_url('/order'); ?>" class="button-link">Browse Menu</a>
        </div>
      </div>
    <?php else: ?>
      <div id="reservation-section-page" style="margin: 2rem auto;">
        <h2>Complete Your Order</h2>
        <p>Review your order and provide delivery details below.</p>

        <!-- Order Summary -->
        <div style="background-color: rgba(255,255,255,0.1); border-radius: 8px; padding: 1.5rem; margin: 2rem 0; text-align: left;">
          <h3 style="margin-top: 0; color: #F5B7C3; font-size: 1.2rem;">Order Summary</h3>
          <?php 
          $subtotal = 0;
          foreach ($cart as $row): 
            $itemTotal = (float)$row['price'] * (int)$row['quantity'];
            $subtotal += $itemTotal;
          ?>
            <div style="display: flex; justify-content: space-between; padding: 0.5rem 0; border-bottom: 1px solid rgba(255,255,255,0.2);">
              <span><?php echo htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8'); ?> × <?php echo (int)$row['quantity']; ?></span>
              <span>$<?php echo number_format($itemTotal, 2); ?></span>
            </div>
          <?php endforeach; ?>
          <div style="display: flex; justify-content: space-between; padding: 1rem 0 0; font-weight: 700; font-size: 1.2rem; color: #F5B7C3;">
            <span>Total:</span>
            <span>$<?php echo number_format((float)($totals['total'] ?? $subtotal), 2); ?></span>
          </div>
        </div>

        <form action="<?php echo base_url('/checkout'); ?>" method="post">
          <?php echo csrf_field(); ?>
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

          <button type="submit" style="width: 100%; max-width: 100%; padding: 12px 0; background-color: #C91818; color: #FFFFFF; border: none; border-radius: 6px; margin-top: 1em; cursor: pointer; transition: 0.3s ease; font-size: 1rem; font-weight: 600;">Place Order ($<?php echo number_format((float)($totals['total'] ?? $subtotal), 2); ?>)</button>
        </form>

        <div style="margin-top: 1.5rem;">
          <a href="<?php echo base_url('/cart'); ?>" style="color: #F5B7C3; text-decoration: underline;">← Back to Cart</a>
        </div>
      </div>
    <?php endif; ?>
  </section>
</main>
