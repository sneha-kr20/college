<?php
include 'db.php';
include 'navigation.php';
include 'header.php';

$result = $conn->query("SELECT * FROM gallery ORDER BY uploaded_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Gallery</title>
</head>
<p><a href="gallery_add.php">➕ Add New Image</a></p>

<body>
  <h2>College Gallery</h2>
  <div style="display:flex; flex-wrap:wrap;">
    <?php while($row = $result->fetch_assoc()): ?>
      <div style="margin:10px; text-align:center;">
        <img src="<?= htmlspecialchars($row['image_path']) ?>" width="200"><br>
        <?= htmlspecialchars($row['caption']) ?>
      </div>
    <?php endwhile; ?>
  </div>
</body>
<?php include 'footer.php';?>
</html>
