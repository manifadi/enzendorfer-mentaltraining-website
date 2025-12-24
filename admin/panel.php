<?php
require_once 'auth_check.php';
require_once '../src/DataManager.php';
require_once 'editor_renderers.php';

$dm = new DataManager();
$sections = $dm->getSections();

// Get current section ID from URL, default to first content section if not set
$activeSectionId = $_GET['section'] ?? null;
$activeSection = null;

// Find the active section object
if ($activeSectionId) {
    foreach ($sections as $sec) {
        if ($sec['id'] === $activeSectionId) {
            $activeSection = $sec;
            break;
        }
    }
}

// Fallback if ID invalid or not set: use first section
if (!$activeSection && !empty($sections)) {
    // Ideally skip 'config' if we want to land on 'Hero', but user can click sidebar.
    // Let's just default to first one.
    $activeSection = reset($sections);
    $activeSectionId = $activeSection['id'];
}

// Handle Form Submission
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newData = $_POST['data'] ?? [];

    // Process Special Fields (Image Uploads, Arrays)
    // Reusing logic similar to edit.php but centralized here or helper function
    // For now, let's keep it simple and assume standard POST processing
    // ... (We will port the detailed processing logic here) ...

    require_once 'save_logic_inc.php'; // Separated logic to keep file clean
}

?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Editor | Neuro CMS</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="admin.css">
    <!-- Frontend Styles for Live Preview Context (optional, but good for fonts/vars) -->
    <!-- We might scope them or just use admin.css to mimic -->
</head>

<body class="cms-layout">

    <!-- SIDEBAR -->
    <aside class="cms-sidebar">
        <div class="sidebar-header">
            <img src="../assets/logos/enzendorfer-logo.png" alt="Logo" class="sidebar-logo">
            <span>NEURO CMS</span>
        </div>

        <nav class="sidebar-nav">
            <?php foreach ($sections as $section): ?>
                <a href="panel.php?section=<?= $section['id'] ?>"
                    class="nav-item <?= $section['id'] === $activeSectionId ? 'active' : '' ?>">
                    <span class="nav-icon">
                        <?php
                        // Simple icon mapping based on type
                        switch ($section['type']) {
                            case 'hero':
                                echo '🏠';
                                break;
                            case 'services':
                                echo '✨';
                                break;
                            case 'about':
                                echo '👤';
                                break;
                            case 'pricing':
                                echo '💶';
                                break;
                            case 'testimonials':
                                echo '💬';
                                break;
                            case 'contact':
                                echo '✉️';
                                break;
                            case 'footer':
                                echo '🦶';
                                break;
                            case 'config':
                                echo '⚙️';
                                break;
                            default:
                                echo '📄';
                        }
                        ?>
                    </span>
                    <span class="nav-label"><?= htmlspecialchars($section['name']) ?></span>
                </a>
            <?php endforeach; ?>
        </nav>

        <div class="sidebar-footer">
            <a href="../" target="_blank" class="btn-view-site">Website öffnen ↗</a>
            <a href="logout.php" class="logout-link">Abmelden</a>
        </div>
    </aside>

    <!-- MAIN EDITOR AREA -->
    <main class="cms-main">
        <?php if ($message): ?>
            <div class="alert <?= strpos($message, 'Fehler') !== false ? 'error' : 'success' ?>"><?= $message ?></div>
        <?php endif; ?>

        <div class="editor-toolbar">
            <h1><?= htmlspecialchars($activeSection['name']) ?></h1>
            <div class="toolbar-actions">
                <!-- Toggle Visibility Form -->
                <form method="POST" action="toggle_inline.php" style="display:inline;">
                    <input type="hidden" name="id" value="<?= $activeSection['id'] ?>">
                    <button type="submit" class="btn-toggle <?= $activeSection['visible'] ? 'visible' : 'hidden' ?>"
                        title="<?= $activeSection['visible'] ? 'Sichtbar' : 'Versteckt' ?>">
                        <?= $activeSection['visible'] ? '👁️ Sichtbar' : '🚫 Versteckt' ?>
                    </button>
                </form>

                <!-- Main Save Button connects to the main form -->
                <button type="submit" form="edit-form" class="btn-save-primary">Speichern</button>
            </div>
        </div>

        <div class="visual-editor-container">
            <!-- The Main Form wrapping the visual editor -->
            <form id="edit-form" method="POST" enctype="multipart/form-data"
                action="panel.php?section=<?= $activeSectionId ?>">
                <input type="hidden" name="section_id" value="<?= $activeSectionId ?>">

                <?php
                // Render the Specific Visual Editor based on type
                renderVisualEditor($activeSection);
                ?>
            </form>
        </div>
    </main>

    <!-- JS Handling for "Add Item" etc -->
    <script src="editor.js"></script>
</body>

</html>