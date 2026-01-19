<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php'; // Ensure you have run 'composer require phpmailer/phpmailer'

function getMailer() {
    $mail = new PHPMailer(true);
    // Server settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';     // Set the SMTP server to send through
    $mail->SMTPAuth   = true;
    $mail->Username   = 'your-email@gmail.com';   // SMTP username
    $mail->Password   = 'your-app-password';      // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Default Sender
    $mail->setFrom('no-reply@karbono.com', 'Karbono Security');
    
    return $mail;
}
?>