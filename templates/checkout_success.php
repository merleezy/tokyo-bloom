<?php $pageTitle = $title ?? 'Order Placed'; ?>
<header id="site-header">
  <a href="<?php echo base_url('/'); ?>#top"><img src="<?php echo asset_url('images/tokyo_bloom_logo.png'); ?>"
      alt="Tokyo Bloom Logo" id="site-logo"></a>
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
      <p>Your order number is <strong>#<?php echo (int) ($orderId ?? 0); ?></strong></p>
      <p>You will receive a confirmation email shortly.</p>
      <div style="margin-top: 2rem; display: flex; gap: 1rem; flex-wrap: wrap; justify-content: center;">
        <a href="<?php echo base_url('/order'); ?>" class="button-link"
          style="background-color: #C91818; flex: 1 1 200px; text-align: center;">Order Again</a>
        <a href="<?php echo base_url('/'); ?>" class="button-link"
          style="background-color: #666; flex: 1 1 200px; text-align: center;">Back to Home</a>
      </div>
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