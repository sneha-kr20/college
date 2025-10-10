<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'db.php';
include 'tailwind.php';  
include 'components.php';
include 'header.php';
   
$allowed_roles = ['admin','teacher','professor','principal','director'];
$result = $conn->query("SELECT id, title, content, file_path, created_at FROM news ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
  <title>Notice Board - Jehal Prasad TTC</title>
</head>

<body class="min-h-screen flex flex-col text-gray-800 font-inter">

  <!-- Main Section -->
  <main class="flex-1 max-w-6xl mx-auto w-full px-4 py-10">

    <!-- Animated Heading -->
    <div class="text-center mb-10 fade-in-up">
      <h1 class="text-4xl md:text-5xl font-extrabold text-collegeblue tracking-tight animate-zoomPulse">
        <!-- <span class="inline-block animate-float mr-2">📢</span> -->
         Announcements 
      </h1>
      <div class="mt-3">
        <div class="h-1 w-20 mx-auto bg-gradient-to-r from-yellow-400 to-orange-500 rounded-full"></div>
        <div class="h-0.5 w-10 mx-auto bg-blue-500/70 mt-1 rounded-full"></div>
      </div>
    </div>

    <!-- Notice Cards -->
    <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3 fade-in-up">
      <?php if ($result && $result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
          <article class="relative glass-card rounded-3xl border border-gray-100 shadow-md hover-lift p-6 flex flex-col justify-between">
            
            <!-- Title & Content -->
            <div>
              <h2 class="text-lg font-semibold text-collegeblue mb-2 transition-colors duration-200 hover:text-blue-700">
                <?= htmlspecialchars($row['title']) ?>
              </h2>
              <p class="text-sm text-gray-700 leading-relaxed mb-4">
                <?= nl2br(htmlspecialchars($row['content'])) ?>
              </p>

              <?php if(!empty($row['file_path'])): ?>
                <a href="<?= htmlspecialchars($row['file_path']) ?>" target="_blank" 
                   class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800 hover:underline transition">
                  📎 View Attachment
                </a>
              <?php endif; ?>
            </div>

            <!-- Footer Info -->
            <footer class="mt-4 border-t border-gray-100 pt-3 text-xs text-gray-500 flex justify-between items-center">
              <span><?= date('M d, Y', strtotime($row['created_at'])) ?></span>
              <a href="https://wa.me/?text=<?= urlencode($row['title'].' - '.$row['content']); ?>" 
                 target="_blank" class="text-green-600 hover:text-green-700 transition flex items-center gap-1">
                 💬 Share
              </a>
            </footer>

            <!-- Delete Button -->
            <?php if (isset($_SESSION['role']) && in_array($_SESSION['role'], $allowed_roles)): ?>
              <form action="news_delete.php" method="POST" 
                    onsubmit="return confirm('Are you sure you want to delete this notice?');" class="mt-4">
                <input type="hidden" name="id" value="<?= htmlspecialchars($row['id']) ?>">
                <button type="submit" 
                        class="w-full bg-gradient-to-r from-red-500 to-red-600 text-white font-semibold py-2 rounded-xl hover:from-red-600 hover:to-red-700 shadow-sm hover:shadow-md transition-all duration-300 btn-hover">
                  🗑 Delete Notice
                </button>
              </form>
            <?php endif; ?>

          </article>
        <?php endwhile; ?>
      <?php else: ?>
        <div class="col-span-full text-center text-gray-500 text-lg bg-white/70 backdrop-blur-sm rounded-2xl py-16 shadow-inner">
          No notices available at the moment 📭
        </div>
      <?php endif; ?>
    </div>
  </main>

  <!-- Floating Add Button (for mobile) -->
  <?php if (isset($_SESSION['role']) && in_array($_SESSION['role'], $allowed_roles)): ?>
    <a href="news_add.php" 
       class="fixed bottom-6 right-6 sm:hidden inline-flex items-center justify-center w-14 h-14 bg-collegeblue text-white rounded-full shadow-lg hover:shadow-xl hover:bg-blue-800 transition-all duration-300 btn-hover">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-7 h-7">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
      </svg>
    </a>
  <?php endif; ?>

</body>
</html>
