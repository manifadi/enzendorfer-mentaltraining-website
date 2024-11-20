<?php
// Empfänger-E-Mail-Adresse
$to = 'nmt.enzendorfer@gmail.com';

// Betreff der E-Mail
$subject = 'Neue Terminanfrage';

// HTML-Inhalt der E-Mail
$name = htmlspecialchars($_POST['name']); // Name aus dem Formular
$email = htmlspecialchars($_POST['email']); // E-Mail aus dem Formular
$messageContent = htmlspecialchars($_POST['message']); // Nachricht aus dem Formular

$message = '<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test E-Mail</title>
    <style>
        /* Grundlegende Stile für die E-Mail */
        body {
            font-family: "Montserrat", sans-serif; /* Schriftart anpassen */
            background-color: #f4f4f4; /* Hintergrundfarbe */
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: white; /* Hintergrundfarbe des Containers */
            padding: 30px; /* Mehr Padding für mehr Raum */
            border-radius: 10px; /* Abgerundete Ecken */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); /* Schatten */
        }
        h2 {
            color: #2c3e50; /* Dunklere Überschrift Farbe */
            font-size: 24px; /* Größere Schriftgröße */
            margin-bottom: 20px; /* Abstand nach unten */
        }
        p {
            color: #34495e; /* Dunklere Textfarbe */
            line-height: 1.6; /* Zeilenhöhe für bessere Lesbarkeit */
            margin: 10px 0; /* Abstand zwischen Absätzen */
        }
        strong {
            color: #5B9B74; /* Farbe für fettgedruckten Text */
        }
        img {
            height: 80px; /* Höhe automatisch anpassen */
            display: block; /* Bild als Blockelement */
            margin: 30px auto 7vh; /* Zentrieren und Abstand nach unten */
        }
        .footer {
            margin-top: 20px; /* Abstand nach oben */
            font-size: 12px; /* Kleinere Schriftgröße für den Footer */
            color: #7f8c8d; /* Graue Farbe für den Footer */
            text-align: center; /* Zentrierter Text */
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="https://nmt-enzendorfer.com/assets/logos/enzendorfer-logo@png.png" alt="Enzendorfer Logo">
        <h2>Neue Terminanfrage</h2>
        <p><strong>Name:</strong> ' . $name . '</p>
        <p><strong>E-Mail:</strong> ' . $email . '</p>
        <p><strong>Nachricht:</strong></p>
        <p>' . $messageContent . '</p>
        <div class="footer">
            <p>&copy; 2023 Enzendorfer. Alle Rechte vorbehalten.</p>
        </div>
    </div>
</body>
</html>
';

// Zusätzliche Header für HTML-E-Mails
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= 'From: "Website Nachricht" <noreply@nmt-enzendorfer.com>' . "\r\n"; // Absendername und -adresse

// E-Mail versenden
if(mail($to, $subject, $message, $headers)) {
    echo "Vielen Dank! Ihre Nachricht wurde gesendet.";
} else {
    echo "Oops! Etwas ist schief gelaufen und wir konnten Ihre Nachricht nicht senden.";
}
?>