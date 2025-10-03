<?php
include 'db.php';
include 'navigation.php';
include 'header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $file_path = NULL;

    if(isset($_FILES["file"]) && $_FILES["file"]["size"] > 0){
        $targetDir = "uploads/";
        $fileName = time() . "_" . basename($_FILES["file"]["name"]);
        $targetFilePath = $targetDir . $fileName;

        if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
            $file_path = $targetFilePath;
        } else {
            echo "<p style='color:red;'>❌ File upload failed.</p>";
        }
    }

    $sql = "INSERT INTO news (title, content, file_path) 
            VALUES ('$title', '$content', '$file_path')";
    if ($conn->query($sql) === TRUE) {
        echo "<p style='color:green;'>✔ Notice added successfully!</p>";
    } else {
        echo "<p style='color:red;'>Error: " . $conn->error . "</p>";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
  <title>Add News / Notice</title>
</head>
<body>
  <h2>Add New Notice</h2>
  <form method="POST" enctype="multipart/form-data">
  <label>Title:</label><br>
  <input type="text" name="title" required style="width:300px;"><br><br>

  <label>Content:</label><br>
  <textarea name="content" rows="5" cols="50" required></textarea><br><br>

  <label>Attach File (PDF/DOC/Image):</label><br>
  <input type="file" name="file"><br><br>

  <button type="submit">Post Notice</button>
</form>


  <p><a href="news.php">⬅ Back to Notice Board</a></p>
</body>
<?php include 'footer.php';?>
</html>
