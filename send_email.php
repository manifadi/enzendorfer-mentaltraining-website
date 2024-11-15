<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $message = strip_tags(trim($_POST["message"]));

    // Check that data was sent to the mailer
    if (empty($name) OR empty($message) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Bitte füllen Sie das Formular aus und versuchen Sie es erneut.";
        exit;
    }

    // Set the recipient email address
    $recipient = "nmt.enzendorfer@gmail.com";

    // Set the email subject
    $subject = "Neue Kontaktanfrage von $name";

    // Build the email content
    $email_content = "Name: $name\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "Nachricht:\n$message\n";

    // Build the email headers
    $email_headers = "From: $name <$email>";

    // Send the email
    if (mail($recipient, $subject, $email_content, $email_headers)) {
        http_response_code(200);
        echo "Vielen Dank! Ihre Nachricht wurde gesendet.";
    } else {
        http_response_code(500);
        echo "Oops! Etwas ist schief gelaufen und wir konnten Ihre Nachricht nicht senden.";
    }
} else {
    http_response_code(403);
    echo "Es gab ein Problem mit Ihrer Übermittlung. Bitte versuchen Sie es erneut.";
}
?>