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
  <title>Reservation Confirmed | Tokyo Bloom</title>
  <link rel="stylesheet" href="../css/style.css">
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
    <section id="confirmation-section">
      <h1>Reservation Confirmed</h1>
      <p>Thank you, <?= htmlspecialchars($reservation['name']) ?>. Your reservation has been booked.</p>
      <ul>
        <li><strong>Date:</strong> <?= htmlspecialchars($reservation['date']) ?></li>
        <li><strong>Time:</strong> <?= htmlspecialchars(substr($reservation['time'], 0, 5)) ?></li>
        <li><strong>Guests:</strong> <?= htmlspecialchars($reservation['guests']) ?></li>
        <li><strong>Email:</strong> <?= htmlspecialchars($reservation['email']) ?></li>
        <li><strong>Phone:</strong> <?= htmlspecialchars($reservation['phone']) ?></li>
      </ul>

      <form action="reservationscancel.php" method="post" style="margin-top: 1rem;">
        <input type="hidden" name="id" value="<?= htmlspecialchars($reservation['id']) ?>">
        <button type="submit" id="cancel-button">Cancel Reservation</button>
      </form>

      <p style="margin-top: 1rem;"><a href="index.html">Return to Home</a></p>
    </section>
  </main>

  <footer id="site-footer">
    <p>&copy; 2025 Tokyo Bloom Sushi and Grill. All rights reserved.</p>
  </footer>
</body>
</html>