<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Database\Connection;
use App\Services\Logger;
use PDO;
use PDOException;

class ReservationRepository
{
  public function __construct(private ?PDO $pdo = null)
  {
    $this->pdo = $pdo ?: Connection::make();
  }

  public function create(array $data): int
  {
    $stmt = $this->pdo->prepare(
      'INSERT INTO reservations (name, email, phone, date, time, guests)
             VALUES (:name, :email, :phone, :date, :time, :guests)'
    );
    $stmt->execute([
      ':name' => $data['name'],
      ':email' => $data['email'],
      ':phone' => $data['phone'],
      ':date' => $data['date'],
      ':time' => $data['time'],
      ':guests' => $data['guests'],
    ]);
    return (int) $this->pdo->lastInsertId();
  }

  public function findById(int $id): ?array
  {
    $stmt = $this->pdo->prepare('SELECT * FROM reservations WHERE id = :id');
    $stmt->execute([':id' => $id]);
    $row = $stmt->fetch();
    return $row ?: null;
  }

  public function getOccupiedTimeSlots(string $date): array
  {
    Logger::info('Repo: checking occupied slots', ['date' => $date]);
    $stmt = $this->pdo->prepare('SELECT time FROM reservations WHERE date = :date');
    $stmt->execute([':date' => $date]);
    $slots = $stmt->fetchAll(PDO::FETCH_COLUMN);
    Logger::info('Repo: found occupied slots', ['date' => $date, 'count' => count($slots), 'slots' => $slots]);
    return $slots;
  }
}
