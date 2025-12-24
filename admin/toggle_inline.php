<?php
require_once 'auth_check.php';
require_once '../src/DataManager.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $dm = new DataManager();
    $id = $_POST['id'];
    $section = $dm->getSectionById($id);

    if ($section) {
        $newState = !$section['visible'];
        $dm->updateSection($id, ['visible' => $newState]);
    }

    // Redirect back to panel with same section open
    header("Location: panel.php?section=" . $id);
    exit;
}
header("Location: panel.php");
exit;
