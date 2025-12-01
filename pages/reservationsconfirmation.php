<?php
require '../dbconnect.php';

$id = $_GET['id'] ?? '';

if ($id === '') {
  die('Reservation ID is missing.');
}

$stmt = $conn->prepare("SELECT * FROM reservations WHERE id = :id");
$stmt->execute([':id' => $id]);
$reservation = $stmt->fetch();

if (!$reservation) {
  die('Reservation not found.');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reservation Confirmed | Tokyo Bloom</title>
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
      <h1>Reservation Confirmed</h1>
    </section>

    <section id="reservation-section-page" style="margin: 3rem auto;">
      <h2 style="color: #2ecc71; margin-bottom: 1rem;">✓ Booking Successful!</h2>
      <p style="font-size: 1.15rem; margin-bottom: 2rem;">Thank you,
        <strong><?= htmlspecialchars($reservation['name']) ?></strong>. Your table has been reserved.</p>

      <div
        style="background-color: rgba(255,255,255,0.1); border-radius: 12px; padding: 2rem; margin: 2rem 0; text-align: left;">
        <h3 style="margin-top: 0; color: #F5B7C3; font-size: 1.2rem; text-align: center; margin-bottom: 1.5rem;">
          Reservation Details</h3>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">
          <div style="text-align: center; padding: 1rem;">
            <div style="font-size: 0.9rem; color: #F5B7C3; margin-bottom: 0.5rem;">DATE</div>
            <div style="font-size: 1.2rem; font-weight: 600;"><?= date('F j, Y', strtotime($reservation['date'])) ?>
            </div>
          </div>

          <div style="text-align: center; padding: 1rem;">
            <div style="font-size: 0.9rem; color: #F5B7C3; margin-bottom: 0.5rem;">TIME</div>
            <div style="font-size: 1.2rem; font-weight: 600;"><?= date('g:i A', strtotime($reservation['time'])) ?>
            </div>
          </div>

          <div style="text-align: center; padding: 1rem;">
            <div style="font-size: 0.9rem; color: #F5B7C3; margin-bottom: 0.5rem;">PARTY SIZE</div>
            <div style="font-size: 1.2rem; font-weight: 600;"><?= htmlspecialchars($reservation['guests']) ?>
              <?= $reservation['guests'] == 1 ? 'Guest' : 'Guests' ?></div>
          </div>
        </div>

        <hr style="border: none; height: 1px; background: rgba(255,255,255,0.2); margin: 1.5rem 0;">

        <div
          style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; font-size: 0.95rem;">
          <div>
            <span style="color: #F5B7C3;">Email:</span><br>
            <?= htmlspecialchars($reservation['email']) ?>
          </div>
          <div>
            <span style="color: #F5B7C3;">Phone:</span><br>
            <?= htmlspecialchars($reservation['phone']) ?>
          </div>
        </div>
      </div>

      <p style="font-size: 1rem; margin: 2rem 0 1.5rem; line-height: 1.8;">
        We look forward to serving you! Please arrive 10 minutes before your reservation time.<br>
        A confirmation email has been sent to your inbox.
      </p>

      <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; margin-top: 2rem;">
        <a href="index.html" class="button-link" style="background-color: #2ecc71;">Back to Home</a>
        <a href="menu.php" class="button-link" style="background-color: #666;">View Menu</a>
      </div>

      <form action="reservationscancel.php" method="post"
        style="margin-top: 3rem; padding-top: 2rem; border-top: 1px solid rgba(255,255,255,0.2);">
        <input type="hidden" name="id" value="<?= htmlspecialchars($reservation['id']) ?>">
        <p style="font-size: 0.9rem; color: #CCC; margin-bottom: 1rem;">Need to change your plans?</p>
        <button type="submit"
          style="background-color: #e74c3c; padding: 0.6rem 1.5rem; border-radius: 999px; border: none; color: white; font-weight: 600; cursor: pointer; transition: all 0.2s ease;">Cancel
          Reservation</button>
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