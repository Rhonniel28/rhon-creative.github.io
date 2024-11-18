<?php
// Include the PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Autoload dependencies (if using Composer)
require 'vendor/autoload.php';  // If using Composer

// Or manually include the PHPMailer files if you're not using Composer
// require 'path/to/PHPMailer/src/Exception.php';
// require 'path/to/PHPMailer/src/PHPMailer.php';
// require 'path/to/PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // reCAPTCHA Verification
    $recaptcha_secret = "6Lf0coIqAAAAAL1Jpwn0pgsPAs4x0DDixYl-xv0z"; // Replace with your Secret Key
    $recaptcha_response = $_POST['g-recaptcha-response'];

    // Send request to Google for reCAPTCHA verification
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$recaptcha_secret&response=$recaptcha_response");
    $response_keys = json_decode($response, true);

    // Check if reCAPTCHA verification succeeded
    if (!$response_keys["success"]) {
        die("reCAPTCHA verification failed. Please try again.");
    }

    // Sanitize and collect form data
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        // Set up mailer to use SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';  // Use Gmail's SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'rhonnielbagaoisan@gmail.com';  // Your Gmail address
        $mail->Password = 'webg imgt cndx wsvo';  // Use your App Password (not your Gmail password)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Sender's email address
        $mail->setFrom('rhonnielbagaoisan@gmail.com', 'RDC email');
        // Recipient's email address (replace with your Gmail or admin email)
        $mail->addAddress('rhonnielbagaoisan@gmail.com', 'Rhonniel');

        // Email content
        $mail->isHTML(true);
        $mail->Subject = 'New Message from Contact Form';
        $mail->Body = "Name: $name<br>Email: $email<br>Message:<br>$message";

        // Send the email
        $mail->send();
        echo 'Message sent successfully!';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
