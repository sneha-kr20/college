<?php
include 'db.php';
include 'navigation.php';
include 'header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $caption = $_POST['caption'];

    // Handle file upload
    $targetDir = "uploads/";
    $fileName = basename($_FILES["image"]["name"]);
    $targetFilePath = $targetDir . time() . "_" . $fileName; // unique name

    if(move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)){
        $sql = "INSERT INTO gallery (image_path, caption)
                VALUES ('$targetFilePath', '$caption')";
        if ($conn->query($sql) === TRUE) {
            echo "<p style='color:green;'>✔ Image uploaded successfully!</p>";
        } else {
            echo "<p style='color:red;'>Database error: " . $conn->error . "</p>";
        }
    } else {
        echo "<p style='color:red;'>❌ File upload failed.</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add Gallery Image</title>
</head>
<body>
  <h2>Add New Image to Gallery</h2>
  <form method="POST" enctype="multipart/form-data">
    <label>Caption:</label> <input type="text" name="caption" required><br><br>
    <label>Image:</label> <input type="file" name="image" accept="image/*" required><br><br>
    <button type="submit">Upload</button>
  </form>

  <p><a href="gallery.php">⬅ Back to Gallery</a></p>
</body>
<?php include 'footer.php';?>
</html>
