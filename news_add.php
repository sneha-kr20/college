<?php
session_start();
include 'db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $file_path = NULL;

    if (isset($_FILES["file"]) && $_FILES["file"]["size"] > 0) {
        $targetDir = "uploads/";
        $fileName = basename($_FILES["file"]["name"]);
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        $allowedTypes = ["pdf", "doc", "docx", "jpg", "jpeg", "png", "gif", "webp"];

        if (in_array($fileExt, $allowedTypes)) {
            $newFileName = uniqid("file_", true) . "." . $fileExt;
            $targetFilePath = $targetDir . $newFileName;

            if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
                $file_path = $targetFilePath;
            } else {
                $message = "<p class='error'>❌ File upload failed.</p>";
            }
        } else {
            $message = "<p class='error'>⚠ Only PDF, DOC, DOCX, JPG, JPEG, PNG, GIF, WEBP are allowed.</p>";
        }
    }

    if ($message === "") {
        $stmt = $conn->prepare("INSERT INTO news (title, content, file_path) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $title, $content, $file_path);

        if ($stmt->execute()) {
            $message = "<p class='success'>✔ Notice added successfully!</p>";
        } else {
            $message = "<p class='error'>Database error: " . $conn->error . "</p>";
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Add News / Notice</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="modal show">
  <div class="modal-content">
    <a href="news.php" class="close">&times;</a>
    <h2>Add New Notice</h2>

    <?= $message ?>

    <form method="POST" enctype="multipart/form-data">
      <input type="text" name="title" placeholder="Title" required><br><br>
      <textarea name="content" rows="5" placeholder="Notice Content" required></textarea><br><br>
      <input type="file" name="file"><br><br>
      <button type="submit">Post Notice</button>
    </form>

    <a href="news.php" class="back-link">Back to Notice Board</a>
  </div>
</div>

</body>
</html>
