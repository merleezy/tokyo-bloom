<?php
declare(strict_types=1);

namespace App\Services;

use Monolog\Logger as MonologLogger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Formatter\LineFormatter;

class Logger
{
  private static ?MonologLogger $instance = null;

  public static function getInstance(): MonologLogger
  {
    if (self::$instance === null) {
      self::$instance = self::createLogger();
    }
    return self::$instance;
  }

  private static function createLogger(): MonologLogger
  {
    $logger = new MonologLogger('tokyo-bloom');

    // Log directory
    $logDir = __DIR__ . '/../../logs';
    if (!is_dir($logDir)) {
      mkdir($logDir, 0755, true);
    }

    // Log format
    $formatter = new LineFormatter(
      "[%datetime%] %channel%.%level_name%: %message% %context% %extra%\n",
      "Y-m-d H:i:s",
      true,
      true
    );

    // Rotating file handler (7 days retention)
    $fileHandler = new RotatingFileHandler(
      $logDir . '/app.log',
      7,
      MonologLogger::DEBUG
    );
    $fileHandler->setFormatter($formatter);
    $logger->pushHandler($fileHandler);

    // Error log for critical issues
    $errorHandler = new StreamHandler(
      $logDir . '/error.log',
      MonologLogger::ERROR
    );
    $errorHandler->setFormatter($formatter);
    $logger->pushHandler($errorHandler);

    return $logger;
  }

  // Convenience methods
  public static function debug(string $message, array $context = []): void
  {
    self::getInstance()->debug($message, $context);
  }

  public static function info(string $message, array $context = []): void
  {
    self::getInstance()->info($message, $context);
  }

  public static function warning(string $message, array $context = []): void
  {
    self::getInstance()->warning($message, $context);
  }

  public static function error(string $message, array $context = []): void
  {
    self::getInstance()->error($message, $context);
  }

  public static function critical(string $message, array $context = []): void
  {
    self::getInstance()->critical($message, $context);
  }
}
