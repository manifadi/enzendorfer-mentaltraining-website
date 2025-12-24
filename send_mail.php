<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Empfänger-E-Mail-Adresse
    $to = 'nmt.enzendorfer@gmail.com';

    // Betreff der E-Mail
    $subject = 'Neue Terminanfrage via Webseite';

    // Daten aus dem Formular
    $name = isset($_POST['name']) ? htmlspecialchars(trim($_POST['name'])) : '';
    $email = isset($_POST['email']) ? htmlspecialchars(trim($_POST['email'])) : '';
    $messageContent = isset($_POST['message']) ? htmlspecialchars(trim($_POST['message'])) : '';

    // Validierung
    if (empty($name) || empty($email) || empty($messageContent) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Fehler zurückgeben
        header("Location: index.php?status=error&msg=Bitte+alle+Felder+korrekt+ausfüllen");
        exit;
    }

    // HTML-Inhalt der E-Mail
    $message = '<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Neue Terminanfrage</title>
    <style>
        body {
            font-family: "Montserrat", sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #2F3E38;
            font-size: 24px;
            margin-bottom: 20px;
            border-bottom: 2px solid #5b9b74;
            padding-bottom: 10px;
        }
        p {
            color: #333;
            line-height: 1.6;
            margin: 10px 0;
        }
        strong {
            color: #5b9b74;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #7f8c8d;
            text-align: center;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Logo Optional -->
        <h2 style="color: #5b9b74;">Neue Terminanfrage</h2>
        <p><strong>Name:</strong> ' . $name . '</p>
        <p><strong>E-Mail:</strong> <a href="mailto:' . $email . '">' . $email . '</a></p>
        <p><strong>Nachricht:</strong></p>
        <div style="background: #f9f9f9; padding: 15px; border-left: 4px solid #5b9b74; border-radius: 4px;">
            ' . nl2br($messageContent) . '
        </div>
        <div class="footer">
            <p>&copy; ' . date('Y') . ' Neuromentaltraining Enzendorfer.</p>
        </div>
    </div>
</body>
</html>';

    // Header für HTML-E-Mails
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: "Website Form" <noreply@nmt-enzendorfer.com>' . "\r\n";
    $headers .= 'Reply-To: ' . $email . "\r\n";

    // E-Mail versenden
    if (mail($to, $subject, $message, $headers)) {
        header("Location: index.php?status=success");
    } else {
        header("Location: index.php?status=error&msg=Senden+fehlgeschlagen");
    }
} else {
    header("Location: index.php");
}
?>