<?php
require_once 'src/DataManager.php';
require_once 'src/Functions.php';

$dm = new DataManager();
$sections = $dm->getSections();

// Define order of generic sections if needed, or just iterate. 
// If the JSON is already ordered (which it is), we just iterate.
// However, 'header_config' and 'footer_config' are special.

$headerConfig = null;
$footerConfig = null;
$contentSections = [];

foreach ($sections as $section) {
    if ($section['type'] === 'config') {
        $headerConfig = $section;
    } elseif ($section['type'] === 'footer') {
        $footerConfig = $section;
    } else {
        $contentSections[] = $section;
    }
}

?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Neurometal Training - Simon Enzendorfer</title>

    <!-- Fonts (using Google Fonts as placeholder, can be replaced) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!-- Main Styles -->
    <link rel="stylesheet" href="styles/style.css">
</head>

<body class="light-mode"> <!-- Default to light mode -->

    <?php if ($headerConfig)
        renderHeader($headerConfig); ?>
    <main>
        <?php foreach ($contentSections as $section): ?>
            <?php
            switch ($section['type']) {
                case 'hero':
                    renderHero($section);
                    break;
                case 'about':
                    renderAbout($section);
                    break;
                case 'services':
                    renderServices($section);
                    break;
                case 'pricing':
                    renderPricing($section);
                    break;
                case 'testimonials':
                    renderTestimonials($section);
                    break;
                case 'contact':
                    renderContact($section);
                    break;
                case 'footer':
                    // Footer is rendered last, outside loop usually, or it's fine here if order matches
                    renderFooter($section);
                    break;
                // Add other types here
            }
            ?>
        <?php endforeach; ?>

    </main>

    <?php if ($footerConfig)
        renderFooter($footerConfig); ?>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="scripts/app.js"></script>
</body>

</html>