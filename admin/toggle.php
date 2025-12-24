<?php
require_once 'auth_check.php';
require_once '../src/DataManager.php';

$id = $_GET['id'] ?? null;
if ($id) {
    $dm = new DataManager();
    $section = $dm->getSectionById($id);
    if ($section) {
        // Toggle visibility
        $section['visible'] = !$section['visible'];
        // Update
        $dm->updateSection($id, ['visible' => $section['visible']]);
    }
}

header('Location: index.php');
exit;
