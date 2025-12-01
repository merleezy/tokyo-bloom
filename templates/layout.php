<?php
/** @var string $content */
/** @var string|null $title */
?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo isset($title) ? htmlspecialchars($title) . ' | ' : ''; ?>Tokyo Bloom | Sushi &amp; Grill</title>
  <link rel="stylesheet" href="<?php echo asset_url('css/style.css'); ?>">
  <link rel="icon" href="<?php echo asset_url('images/tokyo_bloom_icon.png'); ?>" type="image/png">
  <script src="<?php echo asset_url('js/scripts.js'); ?>" defer></script>
  <script>
    window.ASSET_BASE = "<?php echo rtrim(asset_url(''), '/'); ?>/";
  </script>
</head>
<body id="top">
  <?php echo $content; ?>
</body>
</html>
