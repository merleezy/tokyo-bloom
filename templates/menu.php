<header id="site-header">
  <a href="<?php echo base_url('/'); ?>#top"><img src="<?php echo asset_url('images/tokyo_bloom_logo.png'); ?>" alt="Tokyo Bloom Logo" id="site-logo"></a>
  <nav id="nav-bar">
    <ul>
      <li><a href="<?php echo base_url('/'); ?>">Home</a></li>
      <li><a href="<?php echo base_url('/menu'); ?>" aria-current="page">Menu</a></li>
      <li><a href="<?php echo base_url('/order'); ?>">Order Online</a></li>
      <li><a href="<?php echo base_url('/reservations'); ?>">Reservations</a></li>
      <li><a href="<?php echo base_url('/contact'); ?>">Contact</a></li>
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

    <?php /** @var array $categories */ ?>
    <?php /** @var array $itemsByCategory */ ?>

    <div class="menu-category-nav">
      <?php foreach ($categories as $cat): ?>
        <?php $catId = strtolower(str_replace(' ', '-', $cat)); ?>
        <a href="#<?= htmlspecialchars($catId) ?>" class="category-nav-link"><?= htmlspecialchars($cat) ?></a>
      <?php endforeach; ?>
    </div>

    <?php foreach ($categories as $cat): ?>
      <?php $catId = strtolower(str_replace(' ', '-', $cat)); ?>
      <h2 class="menu-category" id="<?= htmlspecialchars($catId) ?>"><?= htmlspecialchars($cat) ?></h2>
      <div class="menu-grid">
        <?php foreach ($itemsByCategory[$cat] as $item): ?>
          <div class="menu-card">
            <?php if (!empty($item['image_url'])): ?>
              <div class="menu-card-image">
                <img src="<?php echo asset_url(htmlspecialchars($item['image_url'])); ?>" alt="<?= htmlspecialchars($item['name']) ?>" loading="lazy" decoding="async">
              </div>
            <?php endif; ?>
            <div class="menu-card-content">
              <h3 class="menu-card-title"><?= htmlspecialchars($item['name']) ?></h3>
              <p class="menu-card-description"><?= htmlspecialchars($item['description']) ?></p>
              <div class="menu-card-price">$<?= number_format((float)$item['price'], 2) ?></div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endforeach; ?>

    <div class="cart-actions" style="text-align: center; margin-top: 2.5rem; padding-top: 2rem; border-top: 2px solid #E0E0E0;">
      <p style="margin-bottom: 1rem; font-size: 1.1rem;">Ready to order?</p>
      <a href="<?php echo base_url('/order'); ?>" class="button-link" style="font-size: 1.05rem; padding: 0.7rem 1.5rem;">Order Online</a>
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
