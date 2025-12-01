<?php
declare(strict_types=1);

namespace App;

use Dotenv\Dotenv;

class Bootstrap
{
  public static function init(string $basePath): array
  {
    if (file_exists($basePath . DIRECTORY_SEPARATOR . '.env')) {
      $dotenv = Dotenv::createImmutable($basePath);
      $dotenv->safeLoad();
    }

    if (session_status() !== PHP_SESSION_ACTIVE) {
      session_start();
    }

    date_default_timezone_set('America/Los_Angeles');

    $debug = filter_var($_ENV['APP_DEBUG'] ?? false, FILTER_VALIDATE_BOOLEAN);
    ini_set('display_errors', $debug ? '1' : '0');
    error_reporting($debug ? E_ALL : E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);

    // Load app config
    $config = require $basePath . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'app.php';

    return $config;
  }
}
