<?php
header('Content-Type: application/json');

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

// Production
require './vendor/autoload.php';

// Local development
//require '/var/www/html/vendor/autoload.php';


// Honeypot-Check
if (!empty($_POST['website'])) {
    echo json_encode(['success' => false, 'error' => 'Spam erkannt.']);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars(trim($_POST["name"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $nachricht = htmlspecialchars(trim($_POST["nachricht"]));

    if (empty($name) || empty($email) || empty($nachricht)) {
        echo json_encode(['success' => false, 'error' => 'Bitte alle Felder ausf端llen.']);
        exit;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'error' => 'Ung端ltige E-Mail-Adresse.']);
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        // Development
        // $mail->Host = 'mailhog';
        // $mail->Port = 1025;
        // $mail->SMTPAuth = false;

        // Production
        $mail->Host = 'mail.cyon.ch';
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->Username = 'info@litschiband.ch';
        $mail->Password = 'Litschiontour_25';
        $mail->SMTPSecure = 'tls';
        $mail->setFrom('info@litschiband.ch', 'Kontaktformular');
        $mail->addAddress('info@litschiband.ch');
        $mail->addReplyTo($email, $name);

        $mail->CharSet = 'UTF-8';
        $mail->Subject = "Neue Nachricht von $name";
        $mail->Body = "Name: $name\nE-Mail: $email\n\nNachricht:\n$nachricht";

        $mail->send();
        echo json_encode(['success' => true]);

    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $mail->ErrorInfo]);
    }
}
?>