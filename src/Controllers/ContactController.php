<?php
declare(strict_types=1);

namespace App\Controllers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Services\Logger;
use App\Services\Validator;

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
      Logger::warning('Contact: invalid request method', ['method' => $_SERVER['REQUEST_METHOD'] ?? 'unknown']);
      header('Location: ' . base_url('/contact'));
      return;
    }

    if (!csrf_verify($_POST['csrf_token'] ?? null)) {
      Logger::warning('Contact: CSRF verification failed');
      $this->render('contact_form', [
        'title' => 'Contact',
        'error' => 'csrf',
        'old' => $_POST
      ]);
      return;
    }

    // Validate input using Validator service
    $validator = new Validator();
    $isValid = $validator->validate($_POST, [
      'name' => 'required|min:2',
      'email' => 'required|email',
      'message' => 'required|min:10'
    ]);

    if (!$isValid) {
      Logger::warning('Contact: validation failed', ['errors' => $validator->errors()]);
      $this->render('contact_form', [
        'title' => 'Contact',
        'errors' => $validator->errors(),
        'old' => $_POST
      ]);
      return;
    }

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

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
      Logger::error('Contact: mail send failed', ['error' => $mail->ErrorInfo]);
      // Continue to confirmation even if mail fails in dev environment
    }

    Logger::info('Contact: message accepted', ['from' => $email, 'name' => $name]);
    header('Location: ' . base_url('/contact/success'));
  }

  public function success(): void
  {
    $this->render('contact_success', [
      'title' => 'Message Sent',
    ]);
  }
}
