<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'path/to/Users/unnati/Desktop/untitled folder/project-group-the-scrubs-2/PHPMailer-master/src/Exception.php';
require 'path/to//Users/unnati/Desktop/untitled folder/project-group-the-scrubs-2/PHPMailer-master/src/PHPMailer.php';
require 'path/to//Users/unnati/Desktop/untitled folder/project-group-the-scrubs-2/PHPMailer-master/src/SMTP.php';
require 'vendor/autoload.php';

$mail = new PHPMailer(true);

$name = $_POST["name"];
$email = $_POST["email"];
$message = $_POST["message"];
try {
    // Server settings
    $mail->SMTPDebug = 0; // Enable verbose debug output
    $mail->isSMTP(); // Set mailer to use SMTP
    $mail->Host = 'smtp.sendgrid.net'; // Specify main and backup SMTP servers
    $mail->SMTPAuth = true; // Enable SMTP authentication
    $mail->Username = 'apikey'; // SMTP username
    $mail->Password = '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'; // SMTP password
    $mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587; // TCP port to connect to

    // Recipients
    $mail->setFrom($email, $name);
    $mail->addAddress('scrubs442@gmail.com', 'Unnati'); // Add a recipient
    //$mail->addCC('x@buffalo.edu');

    // Content
    $mail->isHTML(true); // Set email format to HTML
    $mail->Subject = "Contact form inquiry";
    $mail->Body    = $message
    $mail->send();
    echo 'Message sent successfully';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
