<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'db.php';
include 'tailwind.php';
include 'components.php'; // contains add_button()
include 'header.php';     // uses add_button(), so load AFTER components

$allowed_roles = ['admin','teacher','professor','principal','director'];

$limit = 20;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$result = $conn->query("SELECT id, image_path, thumbnail_path, caption, uploaded_at 
                        FROM gallery ORDER BY uploaded_at DESC LIMIT $limit OFFSET $offset");

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
<body class="min-h-screen flex flex-col font-sans text-gray-800">
  

<!-- Main -->
<main class="flex-1 max-w-6xl mx-auto w-full px-4 py-10">

  <!-- Heading -->
  <div class="text-center mb-10 fade-in-up">
    <h1 class="text-4xl md:text-5xl font-extrabold text-collegeblue tracking-tight animate-zoomPulse">
      <!-- <span class="inline-block animate-float mr-2">🖼️</span>  -->
      Gallery
    </h1>
    <div class="mt-3">
      <div class="h-1 w-20 mx-auto bg-gradient-to-r from-yellow-400 to-orange-500 rounded-full"></div>
      <div class="h-0.5 w-10 mx-auto bg-blue-500/70 mt-1 rounded-full"></div>
    </div>
  </div>

  <!-- Gallery Grid -->
  <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3 fade-in-up">
    <?php if ($result && $result->num_rows > 0): ?>
      <?php while($row = $result->fetch_assoc()): ?>
        <article class="relative glass-card rounded-3xl border border-gray-100 shadow-md hover-lift p-6 flex flex-col justify-between">
          
          <div class="relative group overflow-hidden rounded-2xl">
            <img src="<?= htmlspecialchars($row['thumbnail_path']) ?>" 
                 alt="<?= htmlspecialchars($row['caption'] ?: 'Gallery image') ?>" 
                 class="w-full h-56 object-cover rounded-2xl cursor-pointer transition-transform duration-500 group-hover:scale-105"
                 onclick="openLightbox('<?= htmlspecialchars($row['image_path']) ?>')">
            <div class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 flex items-center justify-center text-white text-lg font-semibold transition-all duration-300">
              View
            </div>
          </div>

          <?php if($row['caption']): ?>
            <p class="text-center text-sm text-gray-700 mt-4"><?= htmlspecialchars($row['caption']) ?></p>
          <?php endif; ?>

          <!-- Footer Info -->
          <footer class="mt-4 border-t border-gray-100 pt-3 text-xs text-gray-500 flex justify-between items-center">
            <span><?= date('M d, Y', strtotime($row['uploaded_at'])) ?></span>
          </footer>

          <!-- Delete Button -->
          <?php if(isset($_SESSION['role']) && in_array($_SESSION['role'], $allowed_roles)): ?>
            <a href="delete.php?type=gallery&id=<?= $row['id'] ?>"
                onclick="return confirm('Are you sure you want to delete this image?');"
                class="block w-full bg-gradient-to-r from-red-500 to-red-600 text-white font-semibold py-2 rounded-xl hover:from-red-600 hover:to-red-700 shadow-sm hover:shadow-md transition-all duration-300 text-center">
               🗑 Delete Image
            </a>

              </button>
            </form>
          <?php endif; ?>

        </article>
      <?php endwhile; ?>
    <?php else: ?>
      <div class="col-span-full text-center text-gray-500 text-lg bg-white/70 backdrop-blur-sm rounded-2xl py-16 shadow-inner">
        No images available!!
      </div>
    <?php endif; ?>
  </div>

  <!-- Pagination -->
  <?php if ($totalPages > 1): ?>
    <div class="flex justify-center items-center gap-3 mt-10">
      <?php if ($page > 1): ?>
        <a href="?page=<?= $page-1 ?>" class="px-4 py-2 bg-collegeblue text-white rounded-full shadow hover:bg-blue-800 transition">← Prev</a>
      <?php endif; ?>
      <span class="text-gray-700 font-medium">Page <?= $page ?> of <?= $totalPages ?></span>
      <?php if ($page < $totalPages): ?>
        <a href="?page=<?= $page+1 ?>" class="px-4 py-2 bg-collegeblue text-white rounded-full shadow hover:bg-blue-800 transition">Next →</a>
      <?php endif; ?>
    </div>
  <?php endif; ?>

</main>

<!-- Mobile Floating Add Button -->
<?php if(isset($_SESSION['role']) && in_array($_SESSION['role'], $allowed_roles)): ?>
  <a href="gallery_add.php" class="fixed bottom-6 right-6 sm:hidden inline-flex items-center justify-center w-14 h-14 bg-collegeblue text-white rounded-full shadow-lg hover:shadow-xl hover:bg-blue-800 transition-all duration-300 btn-hover">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-7 h-7">
      <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
    </svg>
  </a>
<?php endif; ?>

<!-- Lightbox JS -->
<div id="lightbox" class="hidden fixed inset-0 bg-black/90 z-50 flex items-center justify-center p-4">
  <div class="relative">
    <button onclick="closeLightbox()" class="absolute top-2 right-2 text-white text-4xl font-bold hover:text-red-500">&times;</button>
    <img id="lightbox-img" src="" alt="Full Image" class="max-w-[90vw] max-h-[85vh] rounded-2xl shadow-2xl transform transition-transform duration-300 cursor-zoom-in">
  </div>
</div>
<script>
const lightbox = document.getElementById('lightbox');
const lightboxImg = document.getElementById('lightbox-img');
let scale = 1;
function openLightbox(src){
  lightboxImg.src = src;
  scale = 1;
  lightboxImg.style.transform = `scale(${scale})`;
  lightbox.classList.remove('hidden');
}
function closeLightbox(){
  lightbox.classList.add('hidden');
  lightboxImg.src = '';
}
lightbox.addEventListener('click', e => { if(e.target === lightbox) closeLightbox(); });
lightboxImg.addEventListener('wheel', e => {
  e.preventDefault();
  scale += e.deltaY < 0 ? 0.1 : -0.1;
  scale = Math.min(Math.max(scale, 0.5), 3);
  lightboxImg.style.transform = `scale(${scale})`;
});
</script>

</body>
</html>
