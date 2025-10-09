<?php
include 'db.php';
include 'navigation.php';
include 'header.php';
include 'tailwind.php';

// Fetch notices (latest first)
$result = $conn->query("SELECT id, title, content, file_path, created_at FROM news ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Notice Board - Jehal Prasad TTC</title>
</head>
<body class="bg-white font-sans text-gray-900 flex flex-col min-h-screen">

<main class="flex-1 max-w-6xl mx-auto mt-24 mb-12 px-4 grid gap-6 md:grid-cols-2 lg:grid-cols-3">

  <!-- Add Notice Button -->
  <?php if (isset($_SESSION['role']) && in_array($_SESSION['role'], ['admin','teacher','professor','principal','director'])): ?>
    <a href="news_add.php" 
       class="col-span-full bg-collegeblue text-white font-bold text-center px-6 py-3 rounded-lg hover:bg-blue-700 transition">
       + Add New Notice
    </a>
  <?php endif; ?>

  <!-- Notices -->
  <?php while($row = $result->fetch_assoc()): ?>
    <div class="bg-white rounded-lg shadow hover:shadow-lg transition p-6 flex flex-col justify-between">
      <h3 class="text-collegeblue text-lg font-semibold mb-2"><?= htmlspecialchars($row['title']) ?></h3>
      <p class="text-gray-800 text-sm mb-2"><?= nl2br(htmlspecialchars($row['content'])) ?></p>

      <?php if(!empty($row['file_path'])): ?>
        <p class="text-sm text-gray-700">
          Attachment: 
          <a href="<?= htmlspecialchars($row['file_path']) ?>" target="_blank" class="text-blue-600 hover:underline">
            View File
          </a>
        </p>
      <?php endif; ?>

      <div class="mt-3 text-xs text-gray-500">
        <span>Posted on: <?= htmlspecialchars($row['created_at']) ?></span><br>
        <a href="https://wa.me/?text=<?= urlencode($row['title'].' - '.$row['content']); ?>" target="_blank" 
           class="text-green-600 hover:underline">Share on WhatsApp</a>
      </div>
    </div>
  <?php endwhile; ?>
</main>
<?php include 'footer.php'; ?>

</body>
</html>
