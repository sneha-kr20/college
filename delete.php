<?php
session_start();
include 'db.php';

// Roles allowed to delete
$allowed_roles = ['admin', 'teacher', 'professor', 'principal', 'director'];

//  Security checks
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], $allowed_roles)) {
    die("Unauthorized access");
}

if (!isset($_GET['type']) || !isset($_GET['id'])) {
    die("Invalid request");
}

$type = $_GET['type'];
$id = (int)$_GET['id'];

// Determine table and redirect path
switch ($type) {
    case 'news':
        $table = 'news';
        $redirect = 'news.php';
        $file_column = 'file_path';
        break;

    case 'gallery':
        $table = 'gallery';
        $redirect = 'gallery.php';
        $file_column = 'image_path';
        break;

    default:
        die("Invalid delete type");
}

//  Fetch file path (if any)
$stmt = $conn->prepare("SELECT $file_column FROM $table WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($file_path);
$stmt->fetch();
$stmt->close();

//  Delete file if exists
if (!empty($file_path) && file_exists($file_path)) {
    unlink($file_path);
}

//  Delete record
$stmt = $conn->prepare("DELETE FROM $table WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

//  Redirect
header("Location: $redirect?msg=deleted");
exit;
?>
