<?php
include 'db.php';
include 'navigation.php';
include 'header.php';

$result = $conn->query("SELECT * FROM news ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Notice Board</title>
</head>
<body>
  <h2>College Notice Board</h2>

  <?php
  // ✅ Show Add Notice link only if user logged in AND has permission
  if (isset($_SESSION['role']) && in_array($_SESSION['role'], ['admin','teacher','professor','principal','director'])): ?>
    <p><a href="news_add.php">+Add New Notice</a></p>
  <?php endif; ?>

  <?php while($row = $result->fetch_assoc()): ?>
    <div style="border:1px solid #ccc; margin:10px; padding:10px;">
      <h3><?= htmlspecialchars($row['title']) ?></h3>
      <p><?= nl2br(htmlspecialchars($row['content'])) ?></p>

      <?php if(!empty($row['file_path'])): ?>
        <p>Attachment: <a href="<?= $row['file_path'] ?>" target="_blank">View File</a></p>
      <?php endif; ?>

      <small>Posted on: <?= $row['created_at'] ?></small><br>
      <a href="https://wa.me/?text=<?= urlencode($row['title'].' - '.$row['content']); ?>" target="_blank">
        Share on WhatsApp
      </a>
    </div>
  <?php endwhile; ?>

</body>
<?php include 'footer.php';?>
</html>
