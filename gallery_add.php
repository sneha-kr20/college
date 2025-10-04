<?php
session_start();
include 'db.php'; 
include 'navigation.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $caption = trim($_POST['caption']);

    $targetDir = "uploads/";
    $fileName = basename($_FILES["image"]["name"]);
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    $allowedTypes = ["jpg", "jpeg", "png", "gif", "webp"];

    if (in_array($fileExt, $allowedTypes)) {
        $newFileName = uniqid("img_", true) . "." . $fileExt;
        $targetFilePath = $targetDir . $newFileName;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
            $stmt = $conn->prepare("INSERT INTO gallery (image_path, caption) VALUES (?, ?)");
            $stmt->bind_param("ss", $targetFilePath, $caption);

            if ($stmt->execute()) {
                $message = "<p class='success'>✔ Image uploaded successfully!</p>";
            } else {
                $message = "<p class='error'>Database error: " . $conn->error . "</p>";
            }
            $stmt->close();
        } else {
            $message = "<p class='error'> File upload failed.</p>";
        }
    } else {
        $message = "<p class='error'>⚠ Only JPG, JPEG, PNG, GIF, and WEBP files are allowed.</p>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Gallery Image</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body>

<div class="modal show"> 
  <div class="modal-content">
    <a href="gallery.php" class="close">&times;</a>
    <h2>Add New Image</h2>
    
    <?= $message ?>

    <form method="POST" enctype="multipart/form-data">
      <input type="text" name="caption" placeholder="Caption" required><br><br>
      <input type="file" name="image" accept="image/*" required><br><br>
      <button type="submit">Upload</button>
    </form>

    <a href="gallery.php" class="back-link">Back to Gallery</a>
  </div>
</div>
</body>
</html>
