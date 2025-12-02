<header id="site-header">
  <a href="<?php echo base_url('/'); ?>#top"><img src="<?php echo asset_url('images/tokyo_bloom_logo.png'); ?>" alt="Tokyo Bloom Logo" id="site-logo"></a>
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
    <h1>Contact Us</h1>
  </section>

  <section id="reservation-section-page">
    <h2>Contact Us</h2>
    <p>If you have any questions or need assistance, feel free to reach out to us!</p>

    <?php if (!empty($error) && $error === 'csrf'): ?>
      <p class="error-message">Security validation failed. Please try again.</p>
    <?php endif; ?>

    <form id="contact-form" action="<?php echo base_url('/contact'); ?>" method="POST">
      <?php echo csrf_field(); ?>
      <div id="info-container">
        <div id="personal-info">
          <label for="name">Name:</label>
          <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($old['name'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required class="<?php echo !empty($errors['name']) ? 'input-error' : ''; ?>">
          <?php if (!empty($errors['name'])): ?>
            <span class="field-error"><?php echo htmlspecialchars($errors['name'][0], ENT_QUOTES, 'UTF-8'); ?></span>
          <?php endif; ?>

          <label for="email">Email:</label>
          <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($old['email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required class="<?php echo !empty($errors['email']) ? 'input-error' : ''; ?>">
          <?php if (!empty($errors['email'])): ?>
            <span class="field-error"><?php echo htmlspecialchars($errors['email'][0], ENT_QUOTES, 'UTF-8'); ?></span>
          <?php endif; ?>
        </div>

        <div id="reservation-info">
          <label for="message">Message:</label>
          <textarea id="message" name="message" rows="6" required class="<?php echo !empty($errors['message']) ? 'input-error' : ''; ?>"><?php echo htmlspecialchars($old['message'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
          <?php if (!empty($errors['message'])): ?>
            <span class="field-error"><?php echo htmlspecialchars($errors['message'][0], ENT_QUOTES, 'UTF-8'); ?></span>
          <?php endif; ?>
        </div>
      </div>

      <button type="submit" id="submit-button">Send message</button>
    </form>
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
