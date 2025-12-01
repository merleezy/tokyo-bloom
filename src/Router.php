<?php
declare(strict_types=1);

namespace App;

class Router
{
  private array $routes = [];

  public function add(string $method, string $path, callable|array $handler): void
  {
    $this->routes[] = [strtoupper($method), rtrim($path, '/') ?: '/', $handler];
  }

  public function load(array $routeDefs): void
  {
    foreach ($routeDefs as [$method, $path, $handler]) {
      $this->add($method, $path, $handler);
    }
  }

  public function dispatch(): void
  {
    $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
    $uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';

    // Normalize path (strip base path if app is not at domain root)
    $basePath = parse_url($_ENV['APP_URL'] ?? '', PHP_URL_PATH) ?: '';
    if ($basePath && str_starts_with($uri, $basePath)) {
      $uri = substr($uri, strlen($basePath)) ?: '/';
    }

    $uri = rtrim($uri, '/') ?: '/';

    foreach ($this->routes as [$routeMethod, $routePath, $handler]) {
      if ($routeMethod === strtoupper($method) && $routePath === $uri) {
        $this->invoke($handler);
        return; // stop after handling
      }
    }

    http_response_code(404);
    echo '<h1>404 Not Found</h1>';
  }

  private function invoke(callable|array $handler): void
  {
    if (is_array($handler)) {
      [$class, $method] = $handler;
      $instance = new $class();
      $instance->$method();
      return;
    }
    $handler();
  }
}
