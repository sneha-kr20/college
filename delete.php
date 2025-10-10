<?php
session_start();
include 'db.php';

// Roles allowed to delete
$allowed_roles = ['admin', 'teacher', 'professor', 'principal', 'director'];

// Security checks
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], $allowed_roles)) {
    die("Unauthorized access");
}

if (!isset($_GET['type']) || !isset($_GET['id'])) {
    die("Invalid request");
}

$type = $_GET['type'];
$id = (int)$_GET['id'];

// Determine table, file column, and redirect
$mapping = [
    'news' => ['table' => 'news', 'file_column' => 'file_path', 'redirect' => 'news.php'],
    'gallery' => ['table' => 'gallery', 'file_column' => 'image_path', 'redirect' => 'gallery.php'],
    'scholarship' => ['table' => 'scholarship', 'file_column' => '', 'redirect' => 'scholarship.php'], // no files
];

if (!isset($mapping[$type])) {
    die("Invalid delete type");
}

$table = $mapping[$type]['table'];
$file_column = $mapping[$type]['file_column'];
$redirect = $mapping[$type]['redirect'];

// Delete file if applicable
if (!empty($file_column)) {
    $stmt = $conn->prepare("SELECT $file_column FROM $table WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($file_path);
    $stmt->fetch();
    $stmt->close();

    if (!empty($file_path) && file_exists($file_path)) {
        unlink($file_path);
    }
}

// Delete record
$stmt = $conn->prepare("DELETE FROM $table WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

// Redirect
header("Location: $redirect?msg=deleted");
exit;
?>
