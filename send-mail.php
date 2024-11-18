<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // reCAPTCHA Verification
    $recaptcha_secret = "your-secret-key"; // Replace with your Secret Key
    $recaptcha_response = $_POST['g-recaptcha-response'];

    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$recaptcha_secret&response=$recaptcha_response");
    $response_keys = json_decode($response, true);

    if (!$response_keys["success"]) {
        die("reCAPTCHA verification failed. Please try again.");
    }

    // Sanitize and collect form data
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Email Configuration
    $to = "rhonnielbagaoisan@gmail.com"; // Replace with your Gmail address
    $subject = "New Message from Contact Form";
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $body = "You have received a new message:\n\n" .
            "Name: $name\n" .
            "Email: $email\n" .
            "Message:\n$message";

    // Send Email
    if (mail($to, $subject, $body, $headers)) {
        echo "Message sent successfully!";
    } else {
        echo "Failed to send the message. Please try again.";
    }
}
?>
