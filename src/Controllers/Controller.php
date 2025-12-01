<?php
declare(strict_types=1);

namespace App\Controllers;

class Controller
{
  protected function render(string $template, array $data = []): void
  {
    $templateFile = __DIR__ . '/../../templates/' . $template . '.php';
    $layoutFile = __DIR__ . '/../../templates/layout.php';

    if (!file_exists($templateFile)) {
      http_response_code(500);
      echo 'Template not found: ' . htmlspecialchars($template);
      return;
    }

    extract($data, EXTR_OVERWRITE);

    ob_start();
    include $templateFile;
    $content = ob_get_clean();

    include $layoutFile;
  }
}
