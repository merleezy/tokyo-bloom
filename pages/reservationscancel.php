<?php
require '../dbconnect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: reservations.php');
  exit;
}

$id = $_POST['id'] ?? '';

if ($id === '') {
  die('Reservation ID is missing.');
}

$stmt = $conn->prepare("DELETE FROM reservations WHERE id = :id");
$stmt->execute([':id' => $id]);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reservation Canceled | Tokyo Bloom</title>
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
        <li><a href="reservations.php">Reservations</a></li>
        <li><a href="contact.html">Contact</a></li>
      </ul>
    </nav>
  </header>

  <main>
    <section class="page-banner dynamic-hero">
      <h1>Reservation Canceled</h1>
    </section>

    <section id="reservation-section-page" style="margin: 3rem auto;">
      <h2 style="color: #e74c3c; margin-bottom: 1rem;">Reservation Canceled</h2>
      <p style="font-size: 1.15rem; line-height: 1.8; margin-bottom: 2rem;">
        Your reservation has been successfully canceled.<br>
        The time slot is now available for other guests.
      </p>

      <div style="background-color: rgba(255,255,255,0.1); border-radius: 12px; padding: 2rem; margin: 2rem 0;">
        <p style="font-size: 1rem; line-height: 1.8; margin: 0;">
          We're sorry to see you cancel. If you'd like to make a new reservation for a different time, we'd be happy to
          accommodate you.
        </p>
      </div>

      <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; margin-top: 2rem;">
        <a href="reservations.php" class="button-link" style="background-color: #C91818;">Make Another Reservation</a>
        <a href="index.html" class="button-link" style="background-color: #666;">Back to Home</a>
      </div>
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