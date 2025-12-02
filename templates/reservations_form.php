<header id="site-header">
  <a href="<?php echo base_url('/'); ?>#top"><img src="<?php echo asset_url('images/tokyo_bloom_logo.png'); ?>" alt="Tokyo Bloom Logo" id="site-logo"></a>
  <nav id="nav-bar">
    <ul>
      <li><a href="<?php echo base_url('/'); ?>">Home</a></li>
      <li><a href="<?php echo base_url('/menu'); ?>">Menu</a></li>
      <li><a href="<?php echo base_url('/order'); ?>">Order Online</a></li>
      <li><a href="<?php echo base_url('/reservations'); ?>" aria-current="page">Reservations</a></li>
      <li><a href="<?php echo base_url('/contact'); ?>">Contact</a></li>
    </ul>
  </nav>
</header>

<main>
  <section class="page-banner dynamic-hero">
    <h1>Reservations</h1>
  </section>

  <section id="reservation-section-page">
    <h2>Make a Reservation</h2>
    <p>Book your table now for a delightful dining experience.</p>

    <?php if (!empty($error) && $error === 'slot_taken'): ?>
      <p class="error-message">That time slot is already booked. Please choose another time.</p>
    <?php elseif (!empty($error) && $error === 'csrf'): ?>
      <p class="error-message">Security validation failed. Please try again.</p>
    <?php endif; ?>

    <form id="reservation-form" action="<?php echo base_url('/reservations'); ?>" method="post">
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

          <label for="phone">Phone Number:</label>
          <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($old['phone'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required class="<?php echo !empty($errors['phone']) ? 'input-error' : ''; ?>">
          <?php if (!empty($errors['phone'])): ?>
            <span class="field-error"><?php echo htmlspecialchars($errors['phone'][0], ENT_QUOTES, 'UTF-8'); ?></span>
          <?php endif; ?>
        </div>

        <div id="reservation-info">
          <label for="date">Date:</label>
          <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($old['date'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required class="<?php echo !empty($errors['date']) ? 'input-error' : ''; ?>">
          <?php if (!empty($errors['date'])): ?>
            <span class="field-error"><?php echo htmlspecialchars($errors['date'][0], ENT_QUOTES, 'UTF-8'); ?></span>
          <?php endif; ?>

          <label for="time">Time:</label>
          <select id="time" name="time" required class="<?php echo !empty($errors['time']) ? 'input-error' : ''; ?>">
            <?php
            $start = new DateTime('11:00');
            $end = new DateTime('22:00');
            $interval = new DateInterval('PT30M');
            $occupied = $occupiedSlots ?? [];
            $selectedTime = $old['time'] ?? '';
            for ($time = clone $start; $time <= $end; $time->add($interval)) {
              $value = $time->format('H:i:s');
              $label = $time->format('g:i A');
              $isOccupied = in_array($value, $occupied, true);
              $isSelected = $value === $selectedTime ? 'selected' : '';
              if ($isOccupied) {
                echo "<option value=\"{$value}\" disabled>{$label} (Unavailable)</option>";
              } else {
                echo "<option value=\"{$value}\" {$isSelected}>{$label}</option>";
              }
            }
            ?>
          </select>
          <?php if (!empty($errors['time'])): ?>
            <span class="field-error"><?php echo htmlspecialchars($errors['time'][0], ENT_QUOTES, 'UTF-8'); ?></span>
          <?php endif; ?>

          <label for="guests">Number of Guests:</label>
          <select id="guests" name="guests" required class="<?php echo !empty($errors['guests']) ? 'input-error' : ''; ?>">
            <?php 
            $selectedGuests = $old['guests'] ?? 1;
            for ($i = 1; $i <= 20; $i++): 
              $isSelected = $i == $selectedGuests ? 'selected' : '';
            ?>
              <option value="<?= $i ?>" <?= $isSelected ?>><?= $i ?> guest<?= $i > 1 ? 's' : '' ?></option>
            <?php endfor; ?>
          </select>
          <?php if (!empty($errors['guests'])): ?>
            <span class="field-error"><?php echo htmlspecialchars($errors['guests'][0], ENT_QUOTES, 'UTF-8'); ?></span>
          <?php endif; ?>
        </div>
      </div>

      <button type="submit" class="button-link">Complete reservation</button>
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
