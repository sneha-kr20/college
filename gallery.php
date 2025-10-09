<?php
include 'db.php';
include 'navigation.php';
include 'header.php';
include 'tailwind.php';

// ✅ Pagination setup
$limit = 20; // Number of images per page
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// ✅ Optimized MySQL query (uses indexed columns)
$query = "SELECT id, image_path, thumbnail_path, caption, uploaded_at 
          FROM gallery 
          ORDER BY uploaded_at DESC 
          LIMIT $limit OFFSET $offset";
$result = $conn->query($query);

if (!$result) {
    die("Database query failed: " . $conn->error);
}

// ✅ Get total count for pagination
$totalResult = $conn->query("SELECT COUNT(*) AS total FROM gallery");
$totalRows = $totalResult->fetch_assoc()['total'];
$totalPages = ceil($totalRows / $limit);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gallery - Jehal Prasad Teachers Training College</title>
</head>
<body class="bg-gray-50 font-sans flex flex-col min-h-screen">

<main class="flex-1 max-w-6xl mx-auto mt-24 mb-12 px-4 grid gap-6 
             grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">

  <!-- Add Image button for privileged users -->
  <?php if (isset($_SESSION['role']) && in_array($_SESSION['role'], ['admin','professor','principal','director'])): ?>
    <div class="col-span-full flex justify-center mb-6">
  <a href="gallery_add.php"
     class="bg-collegeblue text-white px-6 py-3 rounded-lg font-semibold text-center 
            hover:bg-blue-700 transition shadow-md hover:shadow-lg text-sm sm:text-base">
     + Add New Image
  </a>
</div>

  <?php endif; ?>

  <!-- Gallery Items -->
  <?php while($row = $result->fetch_assoc()): ?>
    <div class="bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden">
      <img src="<?= htmlspecialchars($row['thumbnail_path']) ?>" 
           alt="<?= htmlspecialchars($row['caption'] ?: 'Gallery image') ?>" 
           class="w-full h-48 object-cover cursor-pointer"
           onclick="openLightbox('<?= htmlspecialchars($row['image_path']) ?>')">
      <div class="p-3">
        <p class="text-collegeblue text-center text-sm truncate"><?= htmlspecialchars($row['caption']) ?></p>
      </div>
    </div>
  <?php endwhile; ?>

</main>

<!-- Lightbox Modal -->
<div id="lightbox" class="hidden fixed inset-0 bg-black bg-opacity-90 z-50 flex items-center justify-center">
  <div class="relative">
    <button onclick="closeLightbox()" class="absolute top-2 right-2 text-white text-3xl font-bold z-50 hover:text-red-500">&times;</button>
    <img id="lightbox-img" src="" alt="Full Image" 
         class="max-w-[90vw] max-h-[90vh] rounded-lg shadow-lg transform transition-transform duration-300 cursor-zoom-in">
  </div>
</div>

<script>
  const lightbox = document.getElementById('lightbox');
  const lightboxImg = document.getElementById('lightbox-img');
  let scale = 1;

  function openLightbox(src) {
    lightboxImg.src = src;
    scale = 1;
    lightboxImg.style.transform = `scale(${scale})`;
    lightbox.classList.remove('hidden');
  }

  function closeLightbox() {
    lightbox.classList.add('hidden');
    lightboxImg.src = '';
  }

  lightbox.addEventListener('click', (e) => {
    if (e.target === lightbox) closeLightbox();
  });

  lightboxImg.addEventListener('wheel', (e) => {
    e.preventDefault();
    if (e.deltaY < 0) scale += 0.1;
    else scale -= 0.1;
    scale = Math.min(Math.max(scale, 0.5), 3);
    lightboxImg.style.transform = `scale(${scale})`;
  });
</script>

<!-- Pagination Controls -->
<div class="flex justify-center items-center gap-3 my-8">
  <?php if ($page > 1): ?>
    <a href="?page=<?= $page - 1 ?>" 
       class="px-4 py-2 bg-collegeblue text-white rounded-lg hover:bg-blue-700">Previous</a>
  <?php endif; ?>

  <span class="text-gray-700 font-medium">
    Page <?= $page ?> of <?= $totalPages ?>
  </span>

  <?php if ($page < $totalPages): ?>
    <a href="?page=<?= $page + 1 ?>" 
       class="px-4 py-2 bg-collegeblue text-white rounded-lg hover:bg-blue-700">Next</a>
  <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
