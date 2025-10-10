<?php
session_start();
$current_page = basename($_SERVER['PHP_SELF']);

// Define Add button link dynamically based on page
$page_add_links = [
    'gallery.php' => 'gallery_add.php',
    'news.php' => 'news_add.php',
    'scholarship.php' => 'scholarship_add.php'
];
$add_link = $page_add_links[$current_page] ?? null;
?>
<header class="w-full relative z-50">

<?php if($current_page == 'index.php'): ?>
<!--  Home Page Header -->
<div class="relative overflow-hidden bg-gradient-to-r from-blue-500 via-blue-300 to-blue-600 p-8 md:p-16 text-white shadow-xl">

    <!-- Animated Glow Circles -->
    <div class="absolute top-[-50px] left-[-50px] w-72 h-72 rounded-full bg-yellow-400/20 blur-3xl animate-float"></div>
    <div class="absolute bottom-[-60px] right-[-40px] w-80 h-80 rounded-full bg-pink-400/20 blur-3xl animate-float delay-2000"></div>

    <div class="relative z-10 max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between">
      
        <!-- Logo + College Name -->
        <div class="flex flex-col md:flex-row items-center md:space-x-6 space-y-3 md:space-y-0">
            <img src="images/logo.png" alt="College Logo" class="h-16 w-16 md:h-20 md:w-20 rounded-full shadow-lg animate-zoom-pulse">
            <h1 class="text-3xl md:text-5xl font-extrabold tracking-tight bg-clip-text text-transparent 
                       bg-gradient-to-r from-yellow-400 via-blue-100 to-pink-400 drop-shadow-lg animate-fade-in animate-zoom-pulse relative">
                <span class="inline-block animate-float mr-2">🎓</span>
                Jehal Prasad Teachers Training College
            </h1>
        </div>

        <!-- Desktop Navigation -->
        <nav class="hidden md:flex space-x-6 mt-6 md:mt-0 font-semibold">
            <a href="index.php" class="hover:text-yellow-400 transition-colors">Home</a>
            <a href="scholarship.php" class="hover:text-yellow-400 transition-colors">Scholarship</a>
            <a href="gallery.php" class="hover:text-yellow-400 transition-colors">Gallery</a>
            <a href="news.php" class="hover:text-yellow-400 transition-colors">Notice</a>
            <a href="programmes.php" class="hover:text-yellow-400 transition-colors">Programme</a>
            <a href="about.php" class="hover:text-yellow-400 transition-colors">About Us</a>
        </nav>

        <!-- User Info -->
        <div class="hidden md:flex items-center space-x-4 mt-4 md:mt-0 font-medium">
            <?php if(isset($_SESSION['user'])): ?>
                <span><?= htmlspecialchars($_SESSION['name'] ?? 'User'); ?></span>
                <a href="logout.php" class="btn-danger">Logout</a>
            <?php else: ?>
                <a href="login.php" class="btn-primary">Login</a>
            <?php endif; ?>
        </div>

    </div>

    <!-- Mobile Hamburger + User -->
    <div class="flex md:hidden justify-between items-center mt-6">
        <button id="mobile-menu-button" class="focus:outline-none text-white">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
        <div class="flex items-center space-x-3">
            <?php if(isset($_SESSION['user'])): ?>
                <span class="text-sm truncate max-w-[120px]"><?= htmlspecialchars($_SESSION['name'] ?? 'User'); ?></span>
                <a href="logout.php" class="btn-danger text-sm">Logout</a>
            <?php else: ?>
                <a href="login.php" class="btn-primary text-sm">Login</a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Mobile Menu Vertical Wrap -->
    <div id="mobile-menu" class="hidden md:hidden mt-4 flex flex-col gap-2 bg-blue-800 rounded-lg p-2">
        <a href="index.php" class="px-4 py-2 rounded-lg text-center hover:bg-yellow-400 hover:text-blue-800 transition">Home</a>
        <a href="scholarship.php" class="px-4 py-2 rounded-lg text-center hover:bg-yellow-400 hover:text-blue-800 transition">Scholarship</a>
        <a href="gallery.php" class="px-4 py-2 rounded-lg text-center hover:bg-yellow-400 hover:text-blue-800 transition">Gallery</a>
        <a href="news.php" class="px-4 py-2 rounded-lg text-center hover:bg-yellow-400 hover:text-blue-800 transition">Notice</a>
        <a href="programmes.php" class="px-4 py-2 rounded-lg text-center hover:bg-yellow-400 hover:text-blue-800 transition">Programme</a>
        <a href="about.php" class="px-4 py-2 rounded-lg text-center hover:bg-yellow-400 hover:text-blue-800 transition">About Us</a>
    </div>

</div>

<?php else: ?>
<!-- Other Pages Header: Back + Add -->
<div class="sticky top-0 z-50 backdrop-blur-xl bg-white/70 border-b border-gray-200 shadow-sm relative flex justify-between items-center px-4 py-4">

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

    <!-- Desktop + Mobile Add Button -->
    <?php 
    if($add_link && isset($_SESSION['role']) && in_array($_SESSION['role'], ['admin','teacher','professor','principal','director'])) {
        add_button($add_link,'Add');
    } 
    ?>
</div>
<?php endif; ?>

<script>
const menuButton = document.getElementById('mobile-menu-button');
const mobileMenu = document.getElementById('mobile-menu');
if(menuButton){
    menuButton.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });
}
</script>
