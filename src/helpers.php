<?php
declare(strict_types=1);

// Global helper functions (no namespace)

if (!function_exists('base_url')) {
  function base_url(string $path = ''): string
  {
    $base = rtrim($_ENV['APP_URL'] ?? '', '/');
    return $base . '/' . ltrim($path, '/');
  }
}

if (!function_exists('asset_url')) {
  function asset_url(string $path = ''): string
  {
    // Assets are in public/ directory and accessed via APP_URL
    $base = rtrim($_ENV['APP_URL'] ?? '', '/');
    return $base . '/' . ltrim($path, '/');
  }
}

if (!function_exists('csrf_token')) {
  function csrf_token(): string
  {
    if (empty($_SESSION['csrf_token'])) {
      $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
  }
}

if (!function_exists('csrf_field')) {
  function csrf_field(): string
  {
    $token = htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8');
    return '<input type="hidden" name="csrf_token" value="' . $token . '">';
  }
}

if (!function_exists('csrf_verify')) {
  function csrf_verify(?string $token): bool
  {
    if (!$token || empty($_SESSION['csrf_token'])) {
      return false;
    }
    return hash_equals($_SESSION['csrf_token'], $token);
  }
}
