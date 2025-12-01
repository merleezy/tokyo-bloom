<?php $pageTitle = $title ?? 'Your Cart'; ?>
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
    <h1>Your Cart</h1>
  </section>

  <section id="cart-section">
    <?php if (!empty($error) && $error === 'invalid_csrf'): ?>
      <p class="error">Session expired. Please try again.</p>
    <?php endif; ?>

    <?php if (empty($cart)): ?>
      <div id="checkout-section">
        <h2>Your Cart is Empty</h2>
        <p>Looks like you haven't added any items to your cart yet.</p>
        <a href="<?php echo base_url('/order'); ?>" class="button-link">Browse Menu</a>
      </div>
    <?php else: ?>
      <form action="<?php echo base_url('/cart/update'); ?>" method="post">
        <?php echo csrf_field(); ?>

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
            <?php foreach ($cart as $row): ?>
              <tr>
                <td data-label="Item"><?php echo htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td data-label="Price">$<?php echo number_format((float)$row['price'], 2); ?></td>
                <td data-label="Quantity">
                  <input type="number" name="quantity[<?php echo (int)$row['id']; ?>]" value="<?php echo (int)$row['quantity']; ?>" min="0">
                </td>
                <td data-label="Subtotal">$<?php echo number_format((float)$row['subtotal'], 2); ?></td>
                <td data-label="Action">
                  <form action="<?php echo base_url('/cart/remove'); ?>" method="post" style="display:inline">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="item_id" value="<?php echo (int)$row['id']; ?>">
                    <button type="submit" style="background:none; border:none; color: #C91818; text-decoration: underline; cursor:pointer; padding:0; font-size:inherit;">Remove</button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>

        <p class="cart-total"><strong>Total:</strong> $<?php echo number_format((float)($totals['total'] ?? 0), 2); ?></p>

        <div class="cart-actions">
          <button type="submit">Update Cart</button>
          <a href="<?php echo base_url('/order'); ?>" class="button-link">Continue Shopping</a>
        </div>
      </form>

      <div class="cart-actions" style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 2px solid #E0E0E0;">
        <a href="<?php echo base_url('/checkout'); ?>" class="button-link" style="font-size: 1.05rem; padding: 0.7rem 1.5rem;">Proceed to Checkout</a>

        <form action="<?php echo base_url('/cart/clear'); ?>" method="post" style="display:inline-block; margin-left:1rem;">
          <?php echo csrf_field(); ?>
          <button type="submit" style="background-color: #666; font-size: 0.9rem;" onclick="return confirm('Clear all items from cart?');">Clear Cart</button>
        </form>
      </div>
    <?php endif; ?>
  </section>
</main>
