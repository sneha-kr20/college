<?php
session_start();
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Header</title>
  <?php include 'tailwind.php'; ?>
</head>
<body class="bg-gray-50">

<header class="bg-blue-900 text-white shadow-md">

  <!-- Top Row: Logo + College Name -->
  <div class="max-w-7xl mx-auto px-4 py-4 md:py-6 flex items-center space-x-3">
    <!-- Logo Placeholder -->
    <div class="flex-shrink-0">
      <img src="images/logo.png" alt="College Logo" class="h-12 w-12 md:h-16 md:w-16 object-contain">
    </div>

    <!-- College Name -->
    <h1 class="text-xl sm:text-2xl md:text-3xl font-bold flex-1 break-words">
      Jehal Prasad Teachers Training College
    </h1>
  </div>

  <!-- Second Row: Navigation + User Info -->
  <div class="bg-blue-700/50">
    <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">

      <!-- Navigation Links (Desktop) -->
      <nav class="hidden md:flex space-x-6 font-medium">
        <a href="index.php" class="hover:text-gray-200">Home</a>
        <a href="scholarship.php" class="hover:text-gray-200">Scholarship</a>
        <a href="gallery.php" class="hover:text-gray-200">Gallery</a>
        <a href="news.php" class="hover:text-gray-200">Notice</a>
        <a href="programmes.php" class="hover:text-gray-200">Programme</a>
        <a href="about.php" class="hover:text-gray-200">About Us</a>
      </nav>

      <!-- User Info (Desktop) -->
      <div class="hidden md:flex items-center space-x-3 font-medium">
        <?php if (isset($_SESSION['user'])): ?>
          <span><?= $_SESSION['name']; ?></span>
          <a href="logout.php" class="text-red-400 hover:text-red-200">Logout</a>
        <?php else: ?>
          <a href="login.php" class="hover:text-gray-200">Login</a>
        <?php endif; ?>
      </div>

      <!-- Mobile: Hamburger + User Info -->
      <div class="flex md:hidden items-center justify-between w-full">
        <button id="mobile-menu-button" class="focus:outline-none">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
               viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M4 6h16M4 12h16M4 18h16"></path>
          </svg>
        </button>
        <div class="flex items-center space-x-3">
          <?php if (isset($_SESSION['user'])): ?>
            <span class="text-sm truncate max-w-[120px]"><?= $_SESSION['name']; ?></span>
            <a href="logout.php" class="text-red-400 hover:text-red-200 text-sm">Logout</a>
          <?php else: ?>
            <a href="login.php" class="hover:text-gray-200 text-sm">Login</a>
          <?php endif; ?>
        </div>
      </div>

    </div>

    <!-- Mobile Menu Dropdown -->
    <div id="mobile-menu" class="hidden md:hidden bg-blue-800 border-t border-blue-700">
      <div class="flex flex-col p-4 space-y-2">
        <a href="index.php" class="hover:text-gray-200">Home</a>
        <a href="scholarship.php" class="hover:text-gray-200">Scholarship</a>
        <a href="gallery.php" class="hover:text-gray-200">Gallery</a>
        <a href="news.php" class="hover:text-gray-200">Notice</a>
        <a href="programmes.php" class="hover:text-gray-200">Programme</a>
        <a href="about.php" class="hover:text-gray-200">About Us</a>
      </div>
    </div>

  </div>
</header>


<script>
  const menuButton = document.getElementById('mobile-menu-button');
  const mobileMenu = document.getElementById('mobile-menu');

  if (menuButton) {
    menuButton.addEventListener('click', () => {
      mobileMenu.classList.toggle('hidden');
    });
  }
</script>

<div class="container mx-auto p-4">
<!-- Page Content Starts Here -->
