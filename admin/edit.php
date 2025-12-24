<?php
require_once 'auth_check.php';
$id = $_GET['id'] ?? '';
if ($id) {
    header("Location: panel.php?section=" . urlencode($id));
} else {
    header("Location: panel.php");
}
exit;
?>