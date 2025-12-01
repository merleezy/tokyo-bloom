<?php
declare(strict_types=1);

namespace App\Controllers;
use App\Repositories\MenuRepository;

class MenuController extends Controller
{
  public function index(): void
  {
    $repo = new MenuRepository();
    $data = $repo->getMenu();
    $this->render('menu', [
      'title' => 'Menu',
      'categories' => $data['categories'],
      'itemsByCategory' => $data['itemsByCategory'],
    ]);
  }
}
