<?php
$to = 'your_email@example.com';
$subject = 'Test Email';
$message = 'This is a test email.';
$headers = 'From: no-reply@yourwebsite.com';

if (mail($to, $subject, $message, $headers)) {
    echo 'Email sent successfully.';
} else {
    echo 'Failed to send email.';
}
?>
