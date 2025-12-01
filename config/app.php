<?php
declare(strict_types=1);

return [
  'name' => 'Tokyo Bloom',
  'env' => $_ENV['APP_ENV'] ?? 'production',
  'debug' => filter_var($_ENV['APP_DEBUG'] ?? false, FILTER_VALIDATE_BOOLEAN),
  'url' => rtrim($_ENV['APP_URL'] ?? '', '/'),
  'timezone' => 'America/Los_Angeles',
];
