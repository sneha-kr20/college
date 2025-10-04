<?php
include 'db.php';
include 'navigation.php';
include 'header.php';

$result = $conn->query("SELECT * FROM gallery ORDER BY uploaded_at DESC");
if (!$result) {
    die("Database query failed: " . $conn->error);
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Gallery</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
   <?php if (isset($_SESSION['role']) && in_array($_SESSION['role'], ['admin','teacher','professor','principal','director'])): ?>
  <p><a class="add-link" href="gallery_add.php">+Add New Image</a></p>
<?php endif; ?>
  <div class="gallery-container">
    <?php while($row = $result->fetch_assoc()): ?>
      <div class="gallery-item">
        <img src="<?= htmlspecialchars($row['image_path']) ?>" 
             alt="<?= htmlspecialchars($row['caption'] ?: 'Gallery image') ?>" 
             class="gallery-image">
        <span class="gallery-caption"><?= htmlspecialchars($row['caption']) ?></span>
      </div>
    <?php endwhile; ?>
  </div>
 

</body>
<?php include 'footer.php'; ?>
</html>
