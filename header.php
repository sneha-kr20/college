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

<header class="bg-white shadow-md">
  <div class="max-w-7xl mx-auto p-4 md:p-6">
    
    <?php if ($current_page === 'index.php'): ?>
      <!-- HOME PAGE: Logo + College Name + Navigation -->
      <div class="flex flex-col md:flex-row items-center justify-between">
        <!-- Logo + College Name -->
        <div class="flex items-center space-x-3 mb-4 md:mb-0">
          <!-- <img src="images/name.png" alt="College Logo" class="h-12 w-auto"> -->
          <h1 class="text-2xl md:text-3xl font-bold text-collegeblue">
            Jehal Prasad Teachers Training College
          </h1>
        </div>

        <!-- Desktop Navigation -->
        <nav class="hidden md:flex items-center space-x-6 text-gray-700 font-medium">
          <a href="index.php" class="hover:text-collegeblue">Home</a>
          <a href="scholarship.php" class="hover:text-collegeblue">Scholarships</a>
          <a href="gallery.php" class="hover:text-collegeblue">Gallery</a>
          <a href="news.php" class="hover:text-collegeblue">Notice Board</a>
          <a href="programmes.php" class="hover:text-collegeblue">Programmes</a>
          <a href="about.php" class="hover:text-collegeblue">About Us</a>

          <?php if (isset($_SESSION['user'])): ?>
            <span><?= $_SESSION['name']; ?> | <a href="logout.php" class="hover:text-red-600">Logout</a></span>
          <?php else: ?>
            <a href="login.php" class="hover:text-collegeblue">Login</a>
          <?php endif; ?>
        </nav>

        <!-- Mobile Hamburger -->
        <div class="md:hidden">
          <button id="mobile-menu-button" class="text-gray-700 focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round"
                    d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
          </button>
        </div>
      </div>
    <?php else: ?>
      <!-- OTHER PAGES: Only Navigation -->
      <div class="flex justify-between items-center">
        <nav class="hidden md:flex items-center space-x-6 text-gray-700 font-medium">
          <a href="index.php" class="hover:text-collegeblue">Home</a>
          <a href="scholarship.php" class="hover:text-collegeblue">Scholarships</a>
          <a href="gallery.php" class="hover:text-collegeblue">Gallery</a>
          <a href="news.php" class="hover:text-collegeblue">Notice Board</a>
          <a href="programmes.php" class="hover:text-collegeblue">Programmes</a>
          <a href="about.php" class="hover:text-collegeblue">About Us</a>

          <?php if (isset($_SESSION['user'])): ?>
            <span><?= $_SESSION['name']; ?> | <a href="logout.php" class="hover:text-red-600">Logout</a></span>
          <?php else: ?>
            <a href="login.php" class="hover:text-collegeblue">Login</a>
          <?php endif; ?>
        </nav>

        <!-- Mobile Hamburger -->
        <div class="md:hidden">
          <button id="mobile-menu-button" class="text-gray-700 focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round"
                    d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
          </button>
        </div>
      </div>
    <?php endif; ?>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-200">
      <div class="flex flex-col p-4 space-y-2">
        <a href="index.php" class="hover:text-collegeblue">Home</a>
        <a href="scholarship.php" class="hover:text-collegeblue">Scholarships</a>
        <a href="gallery.php" class="hover:text-collegeblue">Gallery</a>
        <a href="news.php" class="hover:text-collegeblue">Notice Board</a>
        <a href="programmes.php" class="hover:text-collegeblue">Programmes</a>
        <a href="about.php" class="hover:text-collegeblue">About Us</a>

        <?php if (isset($_SESSION['user'])): ?>
          <span><?= $_SESSION['name']; ?> | <a href="logout.php" class="hover:text-red-600">Logout</a></span>
        <?php else: ?>
          <a href="login.php" class="hover:text-collegeblue">Login</a>
        <?php endif; ?>
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
