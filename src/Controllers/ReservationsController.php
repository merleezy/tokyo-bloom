<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Repositories\ReservationRepository;

class ReservationsController extends Controller
{
  public function index(): void
  {
    $error = $_GET['error'] ?? '';
    $selectedDate = $_GET['date'] ?? date('Y-m-d');

    $repo = new ReservationRepository();
    $occupiedSlots = $repo->getOccupiedTimeSlots($selectedDate);

    $this->render('reservations_form', [
      'title' => 'Reservations',
      'error' => $error,
      'selectedDate' => $selectedDate,
      'occupiedSlots' => $occupiedSlots,
    ]);
  }

  public function store(): void
  {
    if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
      header('Location: ' . base_url('/reservations'));
      return;
    }

    if (!csrf_verify($_POST['csrf_token'] ?? null)) {
      header('Location: ' . base_url('/reservations?error=invalid'));
      return;
    }

    $name = trim((string) ($_POST['name'] ?? ''));
    $email = trim((string) ($_POST['email'] ?? ''));
    $phone = trim((string) ($_POST['phone'] ?? ''));
    $date = (string) ($_POST['date'] ?? '');
    $time = (string) ($_POST['time'] ?? '');
    $guests = (int) ($_POST['guests'] ?? 0);

    if ($name === '' || $email === '' || $phone === '' || $date === '' || $time === '' || $guests < 1) {
      header('Location: ' . base_url('/reservations?error=invalid'));
      return;
    }

    $repo = new ReservationRepository();
    try {
      $id = $repo->create([
        'name' => $name,
        'email' => $email,
        'phone' => $phone,
        'date' => $date,
        'time' => $time,
        'guests' => $guests,
      ]);
    } catch (\PDOException $e) {
      if ($e->getCode() === '23000') {
        header('Location: ' . base_url('/reservations?error=slot_taken'));
        return;
      }
      http_response_code(500);
      echo 'Reservation failed.';
      return;
    }

    header('Location: ' . base_url('/reservations/confirm?id=' . urlencode((string) $id)));
  }

  public function confirm(): void
  {
    $id = (int) ($_GET['id'] ?? 0);
    if ($id <= 0) {
      http_response_code(400);
      echo 'Reservation ID is missing.';
      return;
    }
    $repo = new ReservationRepository();
    $reservation = $repo->findById($id);
    if (!$reservation) {
      http_response_code(404);
      echo 'Reservation not found.';
      return;
    }
    $this->render('reservations_success', [
      'title' => 'Reservation Confirmed',
      'reservation' => $reservation,
    ]);
  }

  public function cancel(): void
  {
    if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
      header('Location: ' . base_url('/reservations'));
      return;
    }

    if (!csrf_verify($_POST['csrf_token'] ?? null)) {
      http_response_code(403);
      echo 'Invalid CSRF token.';
      return;
    }

    $id = (int) ($_POST['id'] ?? 0);
    if ($id <= 0) {
      http_response_code(400);
      echo 'Reservation ID is missing.';
      return;
    }

    $repo = new ReservationRepository();
    $reservation = $repo->findById($id);
    if (!$reservation) {
      http_response_code(404);
      echo 'Reservation not found.';
      return;
    }

    // Delete the reservation
    try {
      $stmt = (new \App\Database\Connection())->make()->prepare('DELETE FROM reservations WHERE id = :id');
      $stmt->execute([':id' => $id]);
    } catch (\PDOException $e) {
      http_response_code(500);
      echo 'Failed to cancel reservation.';
      return;
    }

    $this->render('reservations_canceled', [
      'title' => 'Reservation Canceled',
    ]);
  }
}
