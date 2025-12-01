<?php
declare(strict_types=1);

use App\Bootstrap;
use App\Router;

$basePath = dirname(__DIR__);

require $basePath . '/vendor/autoload.php';
require $basePath . '/src/helpers.php';

// Initialize environment and config
$config = Bootstrap::init($basePath);

// Register routes
$routes = require $basePath . '/routes/web.php';
$router = new Router();
$router->load($routes);

// Dispatch request
$router->dispatch();
