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
  <title>Reservation Canceled | Tokyo Bloom</title>
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
        <li><a href="reservations.php">Reservations</a></li>
        <li><a href="contact.html">Contact</a></li>
      </ul>
    </nav>
  </header>

  <main>
    <section id="canceled-section">
      <h1>Reservation Canceled</h1>
      <p>Your reservation has been canceled. That time slot is now available for other guests.</p>
      <p><a href="reservations.php">Make another reservation</a></p>
    </section>
  </main>

  <footer id="site-footer">
    <p>&copy; 2025 Tokyo Bloom Sushi and Grill. All rights reserved.</p>
  </footer>
</body>
</html>
