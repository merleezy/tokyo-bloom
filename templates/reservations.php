<header id="site-header">
  <a href="<?php echo base_url('/'); ?>#top"><img src="<?php echo base_url('../images/tokyo_bloom_logo.png'); ?>" alt="Tokyo Bloom Logo" id="site-logo"></a>
  <nav id="nav-bar">
    <ul>
      <li><a href="<?php echo base_url('/'); ?>">Home</a></li>
      <li><a href="<?php echo base_url('/menu'); ?>">Menu</a></li>
      <li><a href="<?php echo base_url('../pages/order.php'); ?>">Order Online</a></li>
      <li><a href="<?php echo base_url('/reservations'); ?>" aria-current="page">Reservations</a></li>
      <li><a href="<?php echo base_url('../pages/contact.html'); ?>">Contact</a></li>
    </ul>
  </nav>
</header>

<main>
  <section id="reservation-section-page">
    <div id="info-container">
      <h1>Reservations</h1>
      <p>Book your table now for a delightful dining experience.</p>
      <a href="<?php echo base_url('../pages/reservations.php'); ?>" class="home-button">Go to Reservation Form</a>
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
