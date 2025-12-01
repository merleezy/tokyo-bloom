<?php
require '../dbconnect.php';

$errorMessage = '';
if (isset($_GET['error'])) {
  if ($_GET['error'] === 'slot_taken') {
    $errorMessage = 'That time slot is already booked. Please choose another time.';
  } elseif ($_GET['error'] === 'invalid') {
    $errorMessage = 'Please fill out all required fields.';
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reservations | Tokyo Bloom</title>
  <link rel="stylesheet" href="../css/style.css">
  <script src="../js/scripts.js"></script>
</head>

<body id="top">
  <header id="site-header">
    <a href="index.html"><img src="../images/tokyo_bloom_logo.png" alt="Tokyo Bloom Logo" id="site-logo"></a>
    <nav id="nav-bar">
      <ul>
        <li><a href="index.html">Home</a></li>
        <li><a href="menu.php">Menu</a></li>
        <li><a href="order.php">Order Online</a></li>
        <li><a href="reservations.php" aria-current="page">Reservations</a></li>
        <li><a href="contact.html">Contact</a></li>
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

      <?php if (!empty($errorMessage)): ?>
        <p class="error-message"><?= htmlspecialchars($errorMessage) ?></p>
      <?php endif; ?>

      <form id="reservation-form" action="reservationssystem.php" method="post">
        <div id="info-container">
          <div id="personal-info">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="phone">Phone Number:</label>
            <input type="tel" id="phone" name="phone" required>
          </div>

          <div id="reservation-info">
            <label for="date">Date:</label>
            <input type="date" id="date" name="date" required>

            <label for="time">Time:</label>
            <select id="time" name="time" required>
              <?php
              // 30-minute increments from 5:00 PM to 10:00 PM
              $start = new DateTime('11:00');
              $end = new DateTime('22:00');
              $interval = new DateInterval('PT30M');

              for ($time = clone $start; $time <= $end; $time->add($interval)) {
                $value = $time->format('H:i:s');   // DB value
                $label = $time->format('g:i A');   // user label
                echo "<option value=\"{$value}\">{$label}</option>";
              }
              ?>
            </select>

            <label for="guests">Number of Guests:</label>
            <select id="guests" name="guests" required>
              <?php for ($i = 1; $i <= 20; $i++): ?>
                <option value="<?= $i ?>"><?= $i ?> guest<?= $i > 1 ? 's' : '' ?></option>
              <?php endfor; ?>
            </select>
          </div>
        </div>

        <button type="submit" class="button-link">Complete reservation</button>
      </form>
    </section>
  </main>

  <footer id="site-footer">
    <div class="footer-content">
      <div class="footer-section">
        <h3>Tokyo Bloom</h3>
        <p>Authentic Japanese cuisine<br>in the heart of the city</p>
      </div>

      <div class="footer-section">
        <h3>Location</h3>
        <p>123 Sakura Boulevard<br>
          Downtown District<br>
          San Francisco, CA 94102</p>
      </div>

      <div class="footer-section">
        <h3>Contact</h3>
        <p>Phone: (415) 555-SUSHI<br>
          Email: info@tokyobloom.com</p>
      </div>

      <div class="footer-section">
        <h3>Hours</h3>
        <p>Mon-Fri: 11am - 10pm<br>
          Sat: 5pm - 11pm<br>
          Sun: Closed</p>
      </div>
    </div>

    <div class="footer-bottom">
      <p>&copy; 2025 Tokyo Bloom Sushi and Grill. All rights reserved.</p>
    </div>
  </footer>
</body>

</html>