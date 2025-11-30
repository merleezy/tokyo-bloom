<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

// Get the data from the form submitted via contact.html and send it to email
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: contact.html');
    exit;
}

if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['message'])) {
    $mail = new PHPMailer(true);
    
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($name === '' || $email === '' || $message === '') {
        header('Location: contact.html?error=invalid');
        exit;
    }

    // Prepare email
    $to = 'testreceiver@tokyo-bloom.com';
    $subject = 'New Contact Form Submission from ' . $name;
    $body = "Name: $name\nEmail: $email\n\nMessage:\n$message";

    try {
    
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;
    
    // Server settings with MailHog
    $mail->isSMTP();
    $mail->Host       = 'localhost';
    $mail->Port       = 1025;
    $mail->SMTPAuth   = false;
    $mail->SMTPSecure = false;
    
    // Send email
    $mail->setFrom($email, $name);
    $mail->addAddress($to);

    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body    = nl2br(htmlspecialchars($body));
    $mail->AltBody = $body;

    $mail->send();
    echo 'Message sent! Check http://localhost:8025';
} catch (Exception $e) {
    echo "Error: {$mail->ErrorInfo}";
}
    // Redirect to confirmation page
    header('Location: contactconfirmation.html');
    exit;
} else {
    header('Location: contact.html');
    exit;
}

?>