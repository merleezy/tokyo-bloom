<?php
require '../dbconnect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: reservations.php');
    exit;
}

$name   = trim($_POST['name'] ?? '');
$email  = trim($_POST['email'] ?? '');
$phone  = trim($_POST['phone'] ?? '');
$date   = $_POST['date'] ?? '';
$time   = $_POST['time'] ?? '';
$guests = (int)($_POST['guests'] ?? 0);

if ($name === '' || $email === '' || $phone === '' || $date === '' || $time === '' || $guests < 1) {
    header('Location: reservations.php?error=invalid');
    exit;
}

try {
    $stmt = $conn->prepare("
        INSERT INTO reservations (name, email, phone, date, time, guests)
        VALUES (:name, :email, :phone, :date, :time, :guests)
    ");

    $stmt->execute([
        ':name'   => $name,
        ':email'  => $email,
        ':phone'  => $phone,
        ':date'   => $date,
        ':time'   => $time,
        ':guests' => $guests,
    ]);

    $reservationId = $conn->lastInsertId();

    header('Location: reservationsconfirmation.php?id=' . urlencode($reservationId));
    exit;

} catch (PDOException $e) {
    // unique constraint violation (double-booked slot)
    if ($e->getCode() === '23000') {
        header('Location: reservations.php?error=slot_taken');
        exit;
    }

    die('Reservation failed: ' . $e->getMessage());
}