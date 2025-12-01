<?php
declare(strict_types=1);

namespace App\Controllers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ContactController extends Controller
{
  public function index(): void
  {
    $error = $_GET['error'] ?? '';
    $this->render('contact_form', [
      'title' => 'Contact',
      'error' => $error,
    ]);
  }

  public function send(): void
  {
    if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
      header('Location: ' . base_url('/contact'));
      return;
    }

    if (!csrf_verify($_POST['_token'] ?? null)) {
      header('Location: ' . base_url('/contact?error=invalid'));
      return;
    }

    $name = trim((string) ($_POST['name'] ?? ''));
    $email = trim((string) ($_POST['email'] ?? ''));
    $message = trim((string) ($_POST['message'] ?? ''));

    if ($name === '' || $email === '' || $message === '') {
      header('Location: ' . base_url('/contact?error=invalid'));
      return;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      header('Location: ' . base_url('/contact?error=invalid'));
      return;
    }

    // Send email via PHPMailer
    $mail = new PHPMailer(true);
    try {
      $mail->isSMTP();
      $mail->Host = $_ENV['MAIL_HOST'] ?? 'localhost';
      $mail->Port = (int) ($_ENV['MAIL_PORT'] ?? 1025);
      $mail->SMTPAuth = !empty($_ENV['MAIL_USERNAME']);
      $mail->Username = $_ENV['MAIL_USERNAME'] ?? '';
      $mail->Password = $_ENV['MAIL_PASSWORD'] ?? '';
      $mail->SMTPSecure = $_ENV['MAIL_ENCRYPTION'] ?? '';

      $fromAddress = $_ENV['MAIL_FROM_ADDRESS'] ?? 'info@tokyobloom.com';
      $fromName = $_ENV['MAIL_FROM_NAME'] ?? 'Tokyo Bloom';

      $mail->setFrom($fromAddress, $fromName);
      $mail->addReplyTo($email, $name);
      $mail->addAddress($fromAddress);

      $mail->isHTML(true);
      $mail->Subject = 'New Contact Form Submission from ' . $name;
      $mail->Body = nl2br(htmlspecialchars("Name: $name\nEmail: $email\n\nMessage:\n$message", ENT_QUOTES, 'UTF-8'));
      $mail->AltBody = "Name: $name\nEmail: $email\n\nMessage:\n$message";

      $mail->send();
    } catch (Exception $e) {
      error_log('Contact form mail error: ' . $mail->ErrorInfo);
      // Continue to confirmation even if mail fails in dev environment
    }

    header('Location: ' . base_url('/contact/success'));
  }

  public function success(): void
  {
    $this->render('contact_success', [
      'title' => 'Message Sent',
    ]);
  }
}
