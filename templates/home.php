<header id="site-header">
  <a href="<?php echo base_url('/'); ?>#top"><img src="<?php echo asset_url('images/tokyo_bloom_logo.png'); ?>" alt="Tokyo Bloom Logo" id="site-logo"></a>
  <nav id="nav-bar">
    <ul>
      <li><a href="<?php echo base_url('/'); ?>#top" aria-current="page">Home</a></li>
      <li><a href="<?php echo base_url('/menu'); ?>">Menu</a></li>
      <li><a href="<?php echo base_url('/order'); ?>">Order Online</a></li>
      <li><a href="<?php echo base_url('/reservations'); ?>">Reservations</a></li>
      <li><a href="<?php echo base_url('/contact'); ?>">Contact</a></li>
    </ul>
  </nav>
</header>

<main>
  <section id="intro-section" class="dynamic-hero">
    <h1 id="intro-title">Tokyo Bloom <br>Sushi and Grill</h1>
    <div class="intro-actions">
      <a href="<?php echo base_url('/order'); ?>" class="home-button">Order Online</a>
      <a href="#hours-section" class="home-button">Hours</a>
      <a href="<?php echo base_url('/menu'); ?>" class="home-button">Menu</a>
    </div>
  </section>

  <hr class="section-divider">

  <section id="about-us-section">
    <h2>About Us</h2>
    <p class="about-intro">Welcome to Tokyo Bloom Sushi and Grill, where tradition meets innovation. Since 2018, we've been serving authentic Japanese cuisine with a modern twist in the heart of the city.</p>
    <div class="about-content">
      <p>Our master chefs bring over 20 years of experience crafting traditional sushi and innovative fusion dishes. We source the finest, freshest ingredients daily, working directly with local suppliers and importing specialty items from Japan to ensure every dish exceeds your expectations.</p>
      <p>Whether you're joining us for a business lunch, intimate dinner, or special celebration, our warm atmosphere and attentive service create the perfect setting for any occasion.</p>
    </div>
    <div class="features-grid">
      <div class="feature-card">
        <h3>🍱 Fresh Ingredients</h3>
        <p>Locally sourced fish delivered daily, ensuring the highest quality and freshness</p>
      </div>
      <div class="feature-card">
        <h3>👨‍🍳 Expert Chefs</h3>
        <p>Trained in Tokyo with decades of experience in traditional and contemporary cuisine</p>
      </div>
      <div class="feature-card">
        <h3>🌸 Authentic Experience</h3>
        <p>Traditional techniques combined with modern presentation in an elegant setting</p>
      </div>
      <div class="feature-card">
        <h3>🎉 Private Events</h3>
        <p>Host your special occasions with customized menus and private dining options</p>
      </div>
    </div>
  </section>

  <hr class="section-divider">

  <section id="reservation-section">
    <h2>Make a Reservation</h2>
    <p>Book your table now for a delightful dining experience.</p>
    <a href="<?php echo base_url('/reservations'); ?>" class="home-button">Reserve a Table</a>
  </section>

  <hr class="section-divider">

  <section id="location-section">
    <h2>Visit Us</h2>
    <div class="location-content">
      <div class="location-info">
        <h3>📍 Location</h3>
        <p>123 Sakura Boulevard<br>Downtown District<br>San Francisco, CA 94102</p>
      </div>
      <div class="location-info">
        <h3>📞 Contact</h3>
        <p>Phone: (415) 555-SUSHI<br>Email: info@tokyobloom.com</p>
      </div>
      <div class="location-info">
        <h3>🚗 Parking</h3>
        <p>Validated parking available<br>Street parking nearby<br>Valet service on weekends</p>
      </div>
    </div>
    <div class="map-container">
      <h3 style="text-align: center; margin-bottom: 1.5rem; color: #C91818; font-family: 'Lulo Clean', sans-serif;">Find Us on the Map</h3>
      <iframe 
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3153.019494633267!2d-122.41941492346444!3d37.77492971799344!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8085809c6c8f4459%3A0xb10ed6d9b5050fa5!2sUnion%20Square%2C%20San%20Francisco%2C%20CA!5e0!3m2!1sen!2sus!4v1733097600000!5m2!1sen!2sus" 
        width="100%" height="400" style="border:0; border-radius: 12px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
  </section>

  <hr class="section-divider">

  <section id="hours-section">
    <h2>Hours</h2>
    <p id="hours-status"></p>
    <p>Lunch<br>Mon-Fri 11:00 AM - 2:30 PM</p>
    <p>Dinner<br>Mon-Thurs 5:00 PM - 10:00 PM<br>Fri-Sat 5:00 PM - 11:00 PM</p>
    <p>Sunday: Closed</p>
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
