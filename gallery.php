<?php
session_start();
include 'db.php';
include 'tailwind.php';
include 'components.php'; // contains add_button()

// Pagination setup
$limit = 20;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Fetch gallery items
$query = "SELECT id, image_path, thumbnail_path, caption, uploaded_at 
          FROM gallery 
          ORDER BY uploaded_at DESC 
          LIMIT $limit OFFSET $offset";
$result = $conn->query($query);
if (!$result) die("Database query failed: " . $conn->error);

$totalResult = $conn->query("SELECT COUNT(*) AS total FROM gallery");
$totalRows = $totalResult->fetch_assoc()['total'];
$totalPages = ceil($totalRows / $limit);
?>
<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gallery - Jehal Prasad TTC</title>
</head>
<body class="min-h-screen flex flex-col text-gray-800 font-sans overflow-x-hidden">

  <!-- Header -->
  <header class="sticky top-0 z-50 backdrop-blur-xl bg-white/70 border-b border-gray-200 shadow-sm">
    <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center">

      <!-- Back Button -->
      <a href="index.php"
         class="flex items-center justify-center w-12 h-12 rounded-2xl bg-white border border-gray-200 
                shadow-sm hover:shadow-lg text-gray-600 hover:text-white hover:bg-collegeblue 
                hover:border-collegeblue transition-all duration-300">
         <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
              stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
           <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
         </svg>
      </a>

      <!-- Add Button (Desktop + Mobile handled inside function) -->
      <?php add_button('gallery_add.php', 'Add Image'); ?>
    </div>
  </header>

  <!-- Main Content -->
  <main class="flex-1 max-w-6xl mx-auto w-full px-4 py-10">

    <!-- Animated Heading -->
    <div class="relative text-center mb-12">
      <div class="absolute inset-0 flex justify-center">
        <div class="w-72 h-72 bg-gradient-to-r from-blue-500/10 via-yellow-400/10 to-pink-400/10 blur-3xl rounded-full"></div>
      </div>
      <h1 class="relative z-10 text-5xl md:text-6xl font-extrabold tracking-tight 
                 text-transparent bg-clip-text bg-gradient-to-r 
                 from-collegeblue via-blue-700 to-yellow-500 drop-shadow-md 
                 animate-zoom-pulse animate-fade-in">
        <span class="inline-block align-middle mr-2 animate-float">🖼️</span>
        Gallery
      </h1>
      <div class="relative mt-5">
        <span class="block h-1 w-24 mx-auto bg-gradient-to-r from-yellow-400 to-orange-500 rounded-full"></span>
        <span class="block mt-1 h-0.5 w-12 mx-auto bg-blue-500/60 rounded-full"></span>
      </div>
    </div>

    <!-- Gallery Grid -->
    <div class="grid gap-8 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
      <?php if ($result && $result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
          <div class="glass-card rounded-3xl shadow-md hover-lift transition-all duration-500 p-3 animate-fade-in">
            <div class="relative group overflow-hidden rounded-2xl">
              <img src="<?= htmlspecialchars($row['thumbnail_path']) ?>"
                   alt="<?= htmlspecialchars($row['caption'] ?: 'Gallery image') ?>"
                   class="w-full h-56 object-cover rounded-2xl cursor-pointer transition-transform duration-500 group-hover:scale-105"
                   onclick="openLightbox('<?= htmlspecialchars($row['image_path']) ?>')">
              <div class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 flex items-center justify-center text-white text-lg font-semibold transition-all duration-300">
                View
              </div>
            </div>
            <?php if ($row['caption']): ?>
              <p class="text-center text-sm text-gray-700 mt-3"><?= htmlspecialchars($row['caption']) ?></p>
            <?php endif; ?>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <div class="col-span-full text-center text-gray-500 text-lg bg-white/70 backdrop-blur-sm rounded-2xl py-16 shadow-inner animate-fade-in">
          No images available 📭
        </div>
      <?php endif; ?>
    </div>

    <!-- Pagination -->
    <?php if ($totalPages > 1): ?>
      <div class="flex justify-center items-center gap-3 mt-10">
        <?php if ($page > 1): ?>
          <a href="?page=<?= $page - 1 ?>" 
             class="px-4 py-2 bg-collegeblue text-white rounded-full shadow hover:bg-blue-800 transition">
            ← Prev
          </a>
        <?php endif; ?>
        <span class="text-gray-700 font-medium">
          Page <?= $page ?> of <?= $totalPages ?>
        </span>
        <?php if ($page < $totalPages): ?>
          <a href="?page=<?= $page + 1 ?>" 
             class="px-4 py-2 bg-collegeblue text-white rounded-full shadow hover:bg-blue-800 transition">
            Next →
          </a>
        <?php endif; ?>
      </div>
    <?php endif; ?>
  </main>

  <!-- Lightbox -->
  <div id="lightbox" class="hidden fixed inset-0 bg-black/90 z-50 flex items-center justify-center p-4">
    <div class="relative">
      <button onclick="closeLightbox()" class="absolute top-2 right-2 text-white text-4xl font-bold hover:text-red-500">&times;</button>
      <img id="lightbox-img" src="" alt="Full Image" 
           class="max-w-[90vw] max-h-[85vh] rounded-2xl shadow-2xl transform transition-transform duration-300 cursor-zoom-in">
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

    lightbox.addEventListener('click', e => { if (e.target === lightbox) closeLightbox(); });
    lightboxImg.addEventListener('wheel', e => {
      e.preventDefault();
      scale += e.deltaY < 0 ? 0.1 : -0.1;
      scale = Math.min(Math.max(scale, 0.5), 3);
      lightboxImg.style.transform = `scale(${scale})`;
    });
  </script>

</body>
</html>
