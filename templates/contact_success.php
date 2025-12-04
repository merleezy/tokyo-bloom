<header id="site-header">
  <a href="<?php echo base_url('/'); ?>#top"><img src="<?php echo asset_url('images/tokyo_bloom_logo.png'); ?>"
      alt="Tokyo Bloom Logo" id="site-logo"></a>
  <nav id="nav-bar">
    <ul>
      <li><a href="<?php echo base_url('/'); ?>">Home</a></li>
      <li><a href="<?php echo base_url('/menu'); ?>">Menu</a></li>
      <li><a href="<?php echo base_url('/order'); ?>">Order Online</a></li>
      <li><a href="<?php echo base_url('/reservations'); ?>">Reservations</a></li>
      <li><a href="<?php echo base_url('/contact'); ?>" aria-current="page">Contact</a></li>
    </ul>
  </nav>
</header>

<main>
  <section class="page-banner dynamic-hero">
    <h1>Message Sent</h1>
  </section>

  <section id="reservation-section-page" style="margin: 3rem auto;">
    <h2 style="color: #2ecc71; margin-bottom: 1rem;">Thank You!</h2>
    <p style="font-size: 1.15rem; line-height: 1.8; margin-bottom: 2rem;">
      We have received your message and will get back to you as soon as possible.
    </p>

    <div style="background-color: rgba(255,255,255,0.1); border-radius: 12px; padding: 2rem; margin: 2rem 0;">
      <p style="font-size: 1rem; line-height: 1.8; margin: 0; text-align: center;">
        <strong>Response Time:</strong> Typically within 24 hours<br>
        Check your email for our reply!
      </p>
    </div>

    <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; margin-top: 2rem;">
      <a href="<?php echo base_url('/'); ?>" class="button-link" style="background-color: #2ecc71;">Back to Home</a>
      <a href="<?php echo base_url('/menu'); ?>" class="button-link" style="background-color: #666;">View Menu</a>
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