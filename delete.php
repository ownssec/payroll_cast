<?php
require 'db.php';
$id  = $_GET['id'] ?? 0;
$emp = $conn->query("SELECT photo FROM employees WHERE id=$id")->fetch_assoc();
if ($emp) {
    if ($emp['photo'] && file_exists(__DIR__ . '/uploads/' . $emp['photo'])) {
        unlink(__DIR__ . '/uploads/' . $emp['photo']);
    }
    $conn->query("DELETE FROM employees WHERE id=$id");
}
header('Location: index.php');
exit;
?>
