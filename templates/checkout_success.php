<?php $pageTitle = $title ?? 'Order Placed'; ?>
  <header id="site-header">
  <a href="<?php echo base_url('/'); ?>#top"><img src="<?php echo asset_url('images/tokyo_bloom_logo.png'); ?>" alt="Tokyo Bloom Logo" id="site-logo"></a>
  <nav id="nav-bar">
    <ul>
      <li><a href="<?php echo base_url('/'); ?>">Home</a></li>
      <li><a href="<?php echo base_url('/menu'); ?>">Menu</a></li>
      <li><a href="<?php echo base_url('/order'); ?>">Order Online</a></li>
      <li><a href="<?php echo base_url('/reservations'); ?>">Reservations</a></li>
      <li><a href="<?php echo base_url('/contact'); ?>">Contact</a></li>
    </ul>
  </nav>
</header>

<main>
  <section class="page-banner dynamic-hero">
    <h1>Order Confirmed!</h1>
  </section>

  <section id="checkout-section">
    <div id="reservation-section-page" style="margin: 2rem auto;">
      <h2>Thank You for Your Order!</h2>
      <p style="font-size: 1.1rem; margin: 1.5rem 0;">We'll begin preparing your delicious meal right away.</p>
      <p>Your order number is <strong>#<?php echo (int)($orderId ?? 0); ?></strong></p>
      <p>You will receive a confirmation email shortly.</p>
      <div style="margin-top: 2rem; display: flex; gap: 1rem; flex-wrap: wrap; justify-content: center;">
        <a href="<?php echo base_url('/order'); ?>" class="button-link" style="background-color: #C91818; flex: 1 1 200px; text-align: center;">Order Again</a>
        <a href="<?php echo base_url('/'); ?>" class="button-link" style="background-color: #666; flex: 1 1 200px; text-align: center;">Back to Home</a>
      </div>
    </div>
  </section>
</main>
