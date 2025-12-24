<?php
// Main Saving Logic included in panel.php
// $activeSectionId and $newData are already defined in panel.php scope

// Image Handling Helper (Global Top Level + Services)
$topLevelImages = ['background_image', 'image', 'logo_dark', 'logo_light'];
foreach ($topLevelImages as $imgField) {
    if (isset($_FILES[$imgField]) && $_FILES[$imgField]['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES[$imgField]['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '.' . $ext;
        $dest = __DIR__ . '/../assets/uploads/' . $filename;
        if (move_uploaded_file($_FILES[$imgField]['tmp_name'], $dest)) {
            $newData[$imgField] = 'assets/uploads/' . $filename;
        } else {
            // Keep old value if upload fails (though browser sends nothing usually)
        }
    } else {
        // If no file uploaded, keep existing from $activeSection['data'] ??
        // Actually, HTML form inputs with name='field' will send empty string if no text.
        // File inputs don't send text. We rely on hidden input to keep value or just merge.
        // In this implementation, we should MERGE with existing data if key is missing? 
        // No, visual forms submit everything. BUT file inputs are separate.
        // We need to preserve old image paths if no new file is uploaded.
        // Our forms usually don't have hidden inputs for top-level images in my renderer (oops).
        // Let's add that fix logic here:
        if (isset($activeSection['data'][$imgField]) && !isset($newData[$imgField])) {
            $newData[$imgField] = $activeSection['data'][$imgField];
        }
    }
}

// Special Handling: Services (Images + Details)
if (isset($newData['services']) && is_array($newData['services'])) {
    foreach ($newData['services'] as $i => &$svc) {
        // Details Text -> Array
        if (isset($svc['details_text'])) {
            $svc['details'] = array_values(array_filter(array_map('trim', explode("\n", $svc['details_text']))));
            unset($svc['details_text']);
        }

        // Image Upload
        // PHP Files Array for nested arrays is tricky: $_FILES['data']['name']['services'][$i]['image']
        if (
            isset($_FILES['data']['name']['services'][$i]['image']) &&
            $_FILES['data']['error']['services'][$i]['image'] === UPLOAD_ERR_OK
        ) {

            $ext = pathinfo($_FILES['data']['name']['services'][$i]['image'], PATHINFO_EXTENSION);
            $filename = uniqid('svc_') . '.' . $ext;
            $dest = __DIR__ . '/../assets/uploads/' . $filename;

            if (move_uploaded_file($_FILES['data']['tmp_name']['services'][$i]['image'], $dest)) {
                $svc['image'] = 'assets/uploads/' . $filename;
            }
        }
        // If not uploaded, the hidden field in renderer `name='data[services][$i][image]' value='$img'`
        // should have passed the old value. So we are good!
    }
}

// Special Handling: Pricing Cards (CSV Features)
if (isset($newData['cards']) && is_array($newData['cards'])) {
    foreach ($newData['cards'] as &$card) {
        if (isset($card['features_csv'])) {
            $card['features'] = array_map('trim', explode(',', $card['features_csv']));
            unset($card['features_csv']);
        }
    }
}

// Perform Save
if ($dm->updateSection($activeSectionId, ['data' => $newData])) {
    $message = "Änderungen erfolgreich gespeichert!";
    // Refresh active section data
    $activeSection = $dm->getSectionById($activeSectionId);
} else {
    $message = "Fehler beim Speichern der Daten.";
}
?>