<?php
    // Enable error reporting for debugging
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // Sanitize and validate inputs
    $to = 'info@mydrimartgallery.com';
    $firstname = isset($_POST["fname"]) ? htmlspecialchars($_POST["fname"]) : '';
    $email = isset($_POST["email"]) ? htmlspecialchars($_POST["email"]) : '';
    $phone = isset($_POST["phone"]) ? htmlspecialchars($_POST["phone"]) : '';
    $text = isset($_POST["message"]) ? htmlspecialchars($_POST["message"]) : '';

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo 'Invalid email address';
        exit;
    }

    // Check if required fields are not empty
    if (empty($firstname) || empty($email) || empty($text)) {
        echo 'All fields are required';
        exit;
    }

    $subject = 'New Message from MyDrim Gallery Contact Form';

    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";
    $headers .= "From: " . $email . "\r\n";
    $headers .= "Reply-To: " . $email . "\r\n";

    $message = '<!DOCTYPE html>
    <html>
    <body style="font-family: Arial, sans-serif;">
        <div style="max-width: 600px; margin: 0 auto; background-color: #f5f5f5; padding: 20px;">
            <h2 style="color: #333;">New Contact Form Submission</h2>
            <hr style="border: none; border-top: 1px solid #ddd;">
            <p><strong>Name:</strong> ' . $firstname . '</p>
            <p><strong>Email:</strong> ' . $email . '</p>
            <p><strong>Phone:</strong> ' . $phone . '</p>
            <hr style="border: none; border-top: 1px solid #ddd;">
            <p><strong>Message:</strong></p>
            <p>' . nl2br($text) . '</p>
        </div>
    </body>
    </html>';

    // Send mail and provide detailed feedback
    if (mail($to, $subject, $message, $headers)) {
        echo 'The message has been sent successfully.';
        // Log successful submission
        $log_message = date('Y-m-d H:i:s') . " - Email sent from: $email\n";
        file_put_contents('mail_log.txt', $log_message, FILE_APPEND);
    } else {
        echo 'Failed to send email. Please try again later or contact support.';
        // Log failed submission
        $log_error = date('Y-m-d H:i:s') . " - FAILED: Email from: $email - Error: " . error_get_last()['message'] . "\n";
        file_put_contents('mail_log.txt', $log_error, FILE_APPEND);
    }
?>
