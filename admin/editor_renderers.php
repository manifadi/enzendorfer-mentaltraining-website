<?php

function renderVisualEditor($section)
{
    if (!$section)
        return;
    $data = $section['data'];
    $type = $section['type'];

    echo "<div class='visual-preview-wrapper $type-preview'>";

    switch ($type) {
        case 'hero':
            renderHeroEditor($data);
            break;
        case 'about':
            renderAboutEditor($data);
            break;
        case 'services':
            renderServicesEditor($data);
            break;
        case 'pricing':
            renderPricingEditor($data);
            break;
        case 'testimonials':
            renderTestimonialsEditor($data);
            break;
        case 'contact':
            renderContactEditor($data);
            break;
        case 'header':
        case 'config':
            renderConfigEditor($data);
            break;
        case 'footer':
            renderFooterEditor($data);
            break;
        default:
            echo "<p>Kein visueller Editor verfügbar.</p>";
    }

    echo "</div>";
}

// Trash SVG Helper
function getTrashIcon()
{
    return '<svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>';
}

// --- Specific Editors ---

function renderHeroEditor($data)
{
    echo "<div class='visual-hero-bg' style='background-image: url(\"../" . ($data['background_image'] ?? '') . "\");'>";
    echo "<div class='overlay-edit-btn'><label class='btn-file-upload'>Hintergrund ändern <input type='file' name='background_image'></label></div>";

    echo "<div class='visual-hero-split'>";
    // LEFT COLUMN: Headlines
    echo "<div class='hero-left'>";
    // CHANGED TO TEXTAREA FOR WRAPPING (User Request)
    echo "<textarea name='data[headline]' class='visual-input h1-input text-left' rows='3' placeholder='Überschrift' style='text-align:left!important; overflow:hidden;'>" . htmlspecialchars($data['headline'] ?? '') . "</textarea>";
    echo "<textarea name='data[subheadline]' class='visual-input p-input text-left' rows='4' placeholder='Unterüberschrift' style='text-align:left!important;'>" . htmlspecialchars($data['subheadline'] ?? '') . "</textarea>";
    echo "</div>";

    // RIGHT COLUMN: Benefits Swiper
    echo "<div class='hero-right'>";
    echo "<div class='benefit-swiper-controls'>";
    echo "<div class='arrows'>";
    echo "<button type='button' class='swiper-arrow' onclick='prevBenefit()'>←</button>";
    echo "<button type='button' class='swiper-arrow' onclick='nextBenefit()'>→</button>";
    echo "</div>";
    echo "<span class='benefit-counter' id='benefit-counter'>1 / X</span>";
    echo "</div>";

    echo "<div class='visual-benefits-list' id='benefits-container'>";
    $benefits = $data['benefits'] ?? [];
    if (!is_array($benefits))
        $benefits = [];

    foreach ($benefits as $i => $b) {
        echo "<div class='visual-benefit-item'>";
        echo "<button type='button' class='btn-delete-icon' onclick='showDeleteModal(this)'>" . getTrashIcon() . "</button>";
        echo "<input type='text' name='data[benefits][$i][title]' class='visual-input benefit-title' value='" . htmlspecialchars($b['title'] ?? '') . "' placeholder='Titel'>";
        echo "<textarea name='data[benefits][$i][text]' class='visual-input benefit-text' rows='3' placeholder='Text'>" . htmlspecialchars($b['text'] ?? '') . "</textarea>";
        echo "</div>";
    }
    echo "</div>"; // end container

    echo "<button type='button' class='btn-mini-add centered' onclick='addVisualBenefit()'>+ Karte</button>";
    echo "</div>"; // end right
    echo "</div>"; // end split
    echo "</div>"; // end bg
}

function renderAboutEditor($data)
{
    echo "<div class='visual-about-grid'>";
    echo "<div class='visual-about-img'>";
    // FORCE OBJECT FIT CONTAIN
    echo "<img src='../" . ($data['image'] ?? '') . "' class='preview-about-img' style='width:100%; max-height: 500px; object-fit: contain; border-radius:20px;'>";
    echo "<label class='btn-file-upload'>Bild ändern <input type='file' name='image'></label>";
    echo "</div>";
    echo "<div class='visual-about-text'>";
    echo "<div class='headline-group'>";
    echo "<input type='text' name='data[headline]' class='visual-input h2-input' value='" . htmlspecialchars($data['headline'] ?? '') . "'>";
    echo "<input type='text' name='data[highlight_headline]' class='visual-input h2-highlight-input' value='" . htmlspecialchars($data['highlight_headline'] ?? '') . "'>";
    echo "</div>";
    echo "<textarea name='data[text]' class='visual-input body-text-input' rows='12'>" . htmlspecialchars($data['text'] ?? '') . "</textarea>";
    echo "</div>";
    echo "</div>";
}

function renderServicesEditor($data)
{
    echo "<div class='visual-section-header'>";
    echo "<input type='text' name='data[headline]' class='visual-input h2-input' value='" . htmlspecialchars($data['headline'] ?? '') . "'>";
    echo "<input type='text' name='data[highlight_headline]' class='visual-input h2-highlight-input' value='" . htmlspecialchars($data['highlight_headline'] ?? '') . "'>";
    echo "</div>";
    echo "<textarea name='data[intro_text]' class='visual-input centered-text-input' rows='2'>" . htmlspecialchars($data['intro_text'] ?? '') . "</textarea>";

    echo "<div class='visual-services-container' id='services-container'>";
    $services = array_values($data['services'] ?? []);
    foreach ($services as $i => $s) {
        $img = $s['image'] ?? '';
        $details = implode("\n", $s['details'] ?? []);
        echo "<div class='visual-service-card'>";
        echo "<div class='visual-service-visual' style='background-image: url(\"../$img\");'>";
        if (!$img)
            echo "<span class='placeholder-text'>Kein Bild</span>";
        echo "<label class='btn-mini-upload'>📷 <input type='file' name='data[services][$i][image]'></label>";
        echo "<input type='hidden' name='data[services][$i][image]' value='$img'>";
        echo "</div>"; // visual
        echo "<div class='visual-service-content'>";
        echo "<div class='card-actions-top'><button type='button' class='btn-delete-icon' onclick='showDeleteModal(this)'>" . getTrashIcon() . "</button></div>";
        echo "<input type='text' name='data[services][$i][title]' class='visual-input h3-input' value='" . htmlspecialchars($s['title'] ?? '') . "' placeholder='Titel'>";
        echo "<textarea name='data[services][$i][description]' class='visual-input p-small-input' rows='3' placeholder='Beschreibung'>" . htmlspecialchars($s['description'] ?? '') . "</textarea>";
        echo "<label class='small-label'>Details (Eine pro Zeile):</label>";
        echo "<textarea name='data[services][$i][details_text]' class='visual-input details-input' rows='4'>" . htmlspecialchars($details) . "</textarea>";
        echo "</div>"; // content
        echo "</div>"; // card
    }
    echo "</div>";
    echo "<button type='button' class='btn-add-block' onclick='addVisualService()'>+ Neue Dienstleistung</button>";
}

function renderConfigEditor($data)
{
    // PREVIEW ISLAND
    echo "<div class='nav-preview-bar-wrapper'>";
    echo "<div class='nav-preview-bar'>";
    // LOGO
    echo "<div class='brand'>";
    if (!empty($data['logo_dark'])) {
        echo "<img src='../" . htmlspecialchars($data['logo_dark']) . "' style='height:40px; display:block;'>";
    } else {
        echo "LOGO";
    }
    echo "</div>";
    // LINKS
    echo "<div class='nav-preview-links'>";
    $nav_links = $data['nav_links'] ?? [];
    foreach ($nav_links as $link) {
        echo "<span class='nav-preview-link'>" . htmlspecialchars($link['text']) . "</span>";
    }
    echo "</div>";
    echo "</div>";
    echo "</div>";

    // Padded Editor Area matching the screenshot request
    echo "<div class='padded-editor-section'>";
    // Headline flush with boxes
    echo "<div style='max-width:800px; margin:0 auto; margin-bottom:10px;'><h3>Navigationspunkte bearbeiten</h3></div>";

    echo "<div id='nav-container' class='visual-nav-list'>";
    foreach ($nav_links as $i => $link) {
        echo "<div class='visual-nav-item'>";
        // MATCHING THE SCREENSHOT: Just labels and clean inputs, no extra boxes/icons unless requested
        echo "<div><label class='nav-label-small'>Navigationstitel</label>";
        echo "<input type='text' name='data[nav_links][$i][text]' class='visual-input nav-text' value='" . htmlspecialchars($link['text']) . "'></div>";
        echo "<div><label class='nav-label-small'>Anchor Link</label>";
        echo "<input type='text' name='data[nav_links][$i][target]' class='visual-input nav-target' value='" . htmlspecialchars($link['target']) . "'></div>";
        echo "<button type='button' class='btn-delete-icon' style='position:relative;top:auto;right:auto;' onclick='showDeleteModal(this)'>" . getTrashIcon() . "</button>";
        echo "</div>";
    }
    echo "</div>";
    echo "<button type='button' class='btn-mini-add centered-btn' onclick='addVisualNavLink()'>+ Link hinzufügen</button>";

    echo "<hr class='spacer'>";

    echo "<div class='visual-logos-grid'>";
    echo "<div class='logo-box dark'>";
    echo "<img src='../" . ($data['logo_dark'] ?? '') . "' style='max-height:50px;'>";
    echo "<label>Dunkles Logo (Standard) <input type='file' name='logo_dark'></label>";
    echo "</div>";
    echo "<div class='logo-box light' style='background:#333'>";
    echo "<img src='../" . ($data['logo_light'] ?? '') . "' style='max-height:50px;'>";
    echo "<label style='color:white'>Helles Logo (Overlay) <input type='file' name='logo_light'></label>";
    echo "</div>";
    echo "</div>";
    echo "</div>"; // End padding wrapper
}

function renderPricingEditor($data)
{
    echo "<div class='visual-section-header'>";
    echo "<input type='text' name='data[headline]' class='visual-input h2-input' value='" . htmlspecialchars($data['headline'] ?? '') . "'>";
    echo "<input type='text' name='data[highlight_headline]' class='visual-input h2-highlight-input' value='" . htmlspecialchars($data['highlight_headline'] ?? '') . "'>";
    echo "</div>";
    echo "<textarea name='data[intro_text]' class='visual-input centered-text-input' rows='2'>" . htmlspecialchars($data['intro_text'] ?? '') . "</textarea>";

    echo "<div class='visual-pricing-grid' id='cards-container'>";
    $cards = $data['cards'] ?? [];
    foreach ($cards as $i => $c) {
        $features = implode(', ', $c['features'] ?? []);
        $popular = $c['is_popular'] ?? false;
        $price = $c['price'] ?? '';
        $suffix = $c['price_suffix'] ?? '';

        echo "<div class='visual-pricing-card " . ($popular ? 'popular' : '') . "'>";
        echo "<button type='button' class='btn-delete-icon' onclick='showDeleteModal(this)'>" . getTrashIcon() . "</button>";
        echo "<div class='card-badge-select'>";
        echo "<label><input type='checkbox' name='data[cards][$i][is_popular]' value='1' " . ($popular ? 'checked' : '') . "> Hervorheben?</label>";
        echo "</div>";
        echo "<input type='text' name='data[cards][$i][title]' class='visual-input h3-input' value='" . htmlspecialchars($c['title'] ?? '') . "' placeholder='Titel'>";
        echo "<div class='price-row'>";
        echo "<input type='text' name='data[cards][$i][price]' class='visual-input price-input' value='" . htmlspecialchars($price) . "'>";
        echo "<input type='text' name='data[cards][$i][price_suffix]' class='visual-input suffix-input' value='" . htmlspecialchars($suffix) . "'>";
        echo "</div>";
        echo "<label class='small-label'>Features (Kommagetrennt):</label>";
        echo "<textarea name='data[cards][$i][features_csv]' class='visual-input features-input' rows='4'>" . htmlspecialchars($features) . "</textarea>";
        echo "<input type='text' name='data[cards][$i][button_text]' class='visual-input btn-input-mock' value='" . htmlspecialchars($c['button_text'] ?? 'Button') . "'>";
        echo "</div>";
    }
    echo "</div>";
    echo "<button type='button' class='btn-add-block' onclick='addVisualCard()'>+ Neue Preis-Karte</button>";
}


function renderTestimonialsEditor($data)
{
    echo "<div class='visual-section-header'>";
    echo "<input type='text' name='data[headline]' class='visual-input h2-input' value='" . htmlspecialchars($data['headline'] ?? '') . "'>";
    echo "<input type='text' name='data[highlight_headline]' class='visual-input h2-highlight-input' value='" . htmlspecialchars($data['highlight_headline'] ?? '') . "'>";
    echo "</div>";
    echo "<div class='visual-testimonials-grid' id='testimonials-container'>";
    $items = array_values($data['items'] ?? []);
    foreach ($items as $i => $item) {
        echo "<div class='visual-testimonial-card'>";
        echo "<div class='quote-icon'>“</div>";
        echo "<button type='button' class='btn-delete-icon' onclick='showDeleteModal(this)'>" . getTrashIcon() . "</button>";
        echo "<textarea name='data[items][$i][text]' class='visual-input quote-input' rows='4'>" . htmlspecialchars($item['text'] ?? '') . "</textarea>";
        echo "<input type='text' name='data[items][$i][name]' class='visual-input author-input' value='" . htmlspecialchars($item['name'] ?? '') . "'>";
        echo "</div>";
    }
    echo "</div>";
    echo "<button type='button' class='btn-add-block' onclick='addVisualTestimonial()'>+ Kunde hinzufügen</button>";
}

function renderContactEditor($data)
{
    echo "<div class='visual-section-header'>";
    echo "<input type='text' name='data[headline]' class='visual-input h2-input' value='" . htmlspecialchars($data['headline'] ?? '') . "'>";
    echo "<input type='text' name='data[highlight_headline]' class='visual-input h2-highlight-input' value='" . htmlspecialchars($data['highlight_headline'] ?? '') . "'>";
    echo "</div>";

    echo "<div class='visual-contact-layout'>";
    echo "<div class='form-preview'>";
    echo "<h4><input type='text' name='data[form_headline]' class='visual-input' value='" . htmlspecialchars($data['form_headline'] ?? '') . "'></h4>";
    echo "<div class='mock-input'>Name</div>";
    echo "<div class='mock-input'>Email</div>";
    echo "<div class='mock-input'>Nachricht</div>";
    echo "<label class='checkbox-mock'><input type='checkbox' disabled> <input type='text' name='data[checkbox_text]' class='visual-input inline' value='" . htmlspecialchars($data['checkbox_text'] ?? '') . "' style='width:90%'></label>";
    echo "<input type='text' name='data[button_text]' class='visual-input btn-input-mock' value='" . htmlspecialchars($data['button_text'] ?? '') . "'>";

    echo "<hr style='margin: 30px 0; border:0; border-top:1px solid #eee;'>";
    echo "<label class='small-label'>Google Maps Einbettungs-Link (src):</label>";
    echo "<input type='text' name='data[maps_link]' class='visual-input' placeholder='https://www.google.com/maps/embed...' value='" . htmlspecialchars($data['maps_link'] ?? '') . "'>";

    echo "</div>";
    echo "</div>";
}

function renderFooterEditor($data)
{
    echo "<div class='visual-footer-grid'>";
    echo "<div class='footer-col'>";
    echo "<h4>Kontakt Infos</h4>";
    echo "<input type='text' name='data[contact_phone]' class='visual-input' value='" . htmlspecialchars($data['contact_phone'] ?? '') . "' placeholder='Telefon'>";
    echo "<input type='text' name='data[contact_email]' class='visual-input' value='" . htmlspecialchars($data['contact_email'] ?? '') . "' placeholder='Email'>";
    echo "</div>";
    echo "<div class='footer-col'>";
    echo "<h4>Social Links</h4>";
    echo "<div id='social-container'>";
    $social_links = $data['social_links'] ?? [];
    foreach ($social_links as $i => $link) {
        $platform = ucfirst($link['platform'] ?? '');
        echo "<div class='visual-social-item'>";
        echo "<span class='platform-label'>$platform</span>";
        echo "<input type='hidden' name='data[social_links][$i][platform]' value='{$link['platform']}'>";
        echo "<input type='text' name='data[social_links][$i][url]' class='visual-input' value='" . htmlspecialchars($link['url'] ?? '') . "'>";
        echo "</div>";
    }
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "<div class='footer-bottom'>";
    echo "<input type='text' name='data[copyright_text]' class='visual-input centered-text-input' value='" . htmlspecialchars($data['copyright_text'] ?? '') . "'>";
    echo "</div>";
}

?>