<?php
require '../dbconnect.php';

$stmt = $conn->query("SELECT * FROM menu_items ORDER BY category, name");
$items = $stmt->fetchAll();
$currentCategory = '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Menu | Tokyo Bloom</title>
  <link rel="stylesheet" href="../css/style.css">
  <script src="../js/scripts.js"></script>
</head>

<body id="top">
  <header id="site-header">
  <a href="#top"><img src="../images/tokyo_bloom_logo.png" alt="Tokyo Bloom Logo" id="site-logo"></a>
  <nav id="nav-bar">
    <ul>
      <li><a href="index.html">Home</a></li>
      <li><a href="#top" aria-current="page">Menu</a></li>
      <li><a href="order.php">Order Online</a></li>
      <li><a href="reservations.php">Reservations</a></li>
      <li><a href="contact.html">Contact</a></li>
    </ul>
  </nav>
</header>

  <main>
    <section class="page-banner dynamic-hero">
      <h1>Menu</h1>
    </section>
    <section id="menu-section">

<?php foreach ($items as $item): ?>

    <?php if ($item['category'] !== $currentCategory): ?>
        <?php 
            $currentCategory = $item['category']; 
            echo "<h2 class='menu-category'>{$currentCategory}</h2>";
        ?>
    <?php endif; ?>

    <div class="menu-item">
        <?php if (!empty($item['image_url'])): ?>
            <img src="../<?= htmlspecialchars($item['image_url']) ?>" 
                 alt="<?= htmlspecialchars($item['name']) ?>">
        <?php endif; ?>

        <div class="menu-item-info">
            <h3>
                <?= htmlspecialchars($item['name']) ?>
                <span class="menu-price">$<?= number_format($item['price'], 2) ?></span>
            </h3>
            <p><?= htmlspecialchars($item['description']) ?></p>
        </div>
    </div>

<?php endforeach; ?>

  </section>
</main>

  <footer id="site-footer">
    <p id="copyright-text">&copy; 2025 Tokyo Bloom Sushi and Grill. All rights reserved.</p>
  </footer>
</body>

</html>