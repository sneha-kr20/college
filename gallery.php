<?php
if (session_status() === PHP_SESSION_NONE) session_start();

include 'db.php';
include 'tailwind.php';
include 'components.php';
include 'header.php';

$allowed_roles = ['admin','teacher','professor','principal','director'];
$isPrivileged = isset($_SESSION['role']) && in_array($_SESSION['role'], $allowed_roles);

$limit = 20;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Fetch gallery
$result = $conn->query("SELECT id, image_path, thumbnail_path, caption, uploaded_at 
                        FROM gallery ORDER BY uploaded_at DESC LIMIT $limit OFFSET $offset");

$totalResult = $conn->query("SELECT COUNT(*) AS total FROM gallery");
$totalRows = $totalResult->fetch_assoc()['total'];
$totalPages = ceil($totalRows / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Gallery - Jehal Prasad TTC</title>
</head>
<body class="min-h-screen flex flex-col font-sans text-gray-800">

<main class="flex-1 max-w-6xl mx-auto w-full px-4 py-10">

  <!-- Heading -->
  <div class="text-center mb-10">
    <h1 class="text-4xl md:text-5xl font-extrabold text-collegeblue tracking-tight">Gallery</h1>
    <div class="mt-3">
      <div class="h-1 w-20 mx-auto bg-gradient-to-r from-yellow-400 to-orange-500 rounded-full"></div>
      <div class="h-0.5 w-10 mx-auto bg-blue-500/70 mt-1 rounded-full"></div>
    </div>
  </div>

  <!-- Gallery Grid -->
  <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
    <?php if($result && $result->num_rows > 0): ?>
      <?php while($row = $result->fetch_assoc()): ?>
        
        <!-- CSS-only Lightbox: hidden checkbox -->
        <input type="checkbox" id="img-<?= $row['id'] ?>" class="hidden peer">
        
        <article class="relative glass-card rounded-3xl border border-gray-100 shadow-md overflow-hidden">
          <!-- Thumbnail -->
          <label for="img-<?= $row['id'] ?>" class="cursor-pointer group block relative">
            <img src="<?= htmlspecialchars($row['thumbnail_path']) ?>" alt="<?= htmlspecialchars($row['caption'] ?: 'Gallery image') ?>" class="w-full h-56 object-cover transition-transform duration-300 group-hover:scale-105">
            <div class="absolute inset-0 bg-black/25 opacity-0 group-hover:opacity-100 flex items-center justify-center text-white font-semibold transition-all duration-300">View</div>
          </label>

          <?php if($row['caption']): ?>
            <p class="text-center text-sm text-gray-700 mt-2 px-2"><?= htmlspecialchars($row['caption']) ?></p>
          <?php endif; ?>

          <footer class="mt-2 border-t border-gray-100 pt-2 text-xs text-gray-500 text-center">
            <?= date('M d, Y', strtotime($row['uploaded_at'])) ?>
          </footer>

          <?php if($isPrivileged): ?>
            <a href="delete.php?type=gallery&id=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this image?');"
               class="block w-full bg-red-500 text-white font-semibold py-2 mt-2 rounded-lg text-center hover:bg-red-600 transition">× Delete</a>
          <?php endif; ?>
        </article>

        <!-- Lightbox -->
        <div class="fixed inset-0 bg-black/80 flex items-center justify-center p-4 opacity-0 pointer-events-none peer-checked:opacity-100 peer-checked:pointer-events-auto transition-opacity z-50">
          <label for="img-<?= $row['id'] ?>" class="absolute inset-0 cursor-pointer"></label>
          <img src="<?= htmlspecialchars($row['image_path']) ?>" class="max-w-full max-h-[90vh] rounded-2xl shadow-2xl z-10" alt="">
        </div>

      <?php endwhile; ?>
    <?php else: ?>
      <div class="col-span-full text-center text-gray-500 text-lg bg-white/70 backdrop-blur-sm rounded-2xl py-16 shadow-inner">No images available!</div>
    <?php endif; ?>
  </div>

  <!-- Pagination -->
  <?php if($totalPages > 1): ?>
    <div class="flex justify-center items-center gap-3 mt-10">
      <?php if($page > 1): ?>
        <a href="?page=<?= $page-1 ?>" class="px-4 py-2 bg-collegeblue text-white rounded-full shadow hover:bg-blue-800 transition">← Prev</a>
      <?php endif; ?>
      <span class="text-gray-700 font-medium">Page <?= $page ?> of <?= $totalPages ?></span>
      <?php if($page < $totalPages): ?>
        <a href="?page=<?= $page+1 ?>" class="px-4 py-2 bg-collegeblue text-white rounded-full shadow hover:bg-blue-800 transition">Next →</a>
      <?php endif; ?>
    </div>
  <?php endif; ?>

</main>

<!-- Mobile Floating Add Button -->
<?php if($isPrivileged): ?>
  <a href="gallery_add.php" class="fixed bottom-6 right-6 sm:hidden inline-flex items-center justify-center w-14 h-14 bg-collegeblue text-white rounded-full shadow-lg hover:shadow-xl hover:bg-blue-800 transition-all duration-300">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-7 h-7">
      <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
    </svg>
  </a>
<?php endif; ?>

</body>
</html>
