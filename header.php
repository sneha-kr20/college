<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$current_page = basename($_SERVER['PHP_SELF']);

// Define Add button links for each page
$page_add_links = [
    'gallery.php' => 'gallery_add.php',
    'news.php' => 'news_add.php',
    'scholarship.php' => 'scholarship_add.php',
];
$add_link = $page_add_links[$current_page] ?? null;
?>

<header class="w-full relative z-50">

<?php if ($current_page == 'index.php'): ?>
<!-- 🏠 Home Page Header -->
<div class="relative overflow-hidden bg-gradient-to-r from-blue-500 via-blue-300 to-blue-600 p-8 md:p-16 text-white shadow-xl">

    <!-- Animated Background Glow -->
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
        <div class="hidden md:flex items-center justify-center md:justify-between w-full mt-8 md:mt-0 flex-wrap gap-6">

            <!-- Navigation -->
            <nav class="flex flex-wrap justify-center space-x-6 md:space-x-10 font-semibold">
                <a href="index.php" class="hover:text-yellow-400 transition-colors">Home</a>
                <a href="scholarship.php" class="hover:text-yellow-400 transition-colors">Scholarship</a>
                <a href="gallery.php" class="hover:text-yellow-400 transition-colors">Gallery</a>
                <a href="news.php" class="hover:text-yellow-400 transition-colors">Notice</a>
                <a href="programmes.php" class="hover:text-yellow-400 transition-colors">Programme</a>
                <a href="about.php" class="hover:text-yellow-400 transition-colors">About Us</a>
            </nav>

            <!-- User Info -->
            <div class="flex items-center space-x-4 font-medium mt-4 md:mt-0">
                <?php if(isset($_SESSION['user'])): ?>
                    <span class="truncate max-w-[140px] text-ellipsis overflow-hidden"><?= htmlspecialchars($_SESSION['name'] ?? 'User'); ?></span>
                    <a href="logout.php" class="btn-danger whitespace-nowrap">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="btn-primary whitespace-nowrap">Login</a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Mobile Navigation -->
        <div class="md:hidden mt-6">
            <input type="checkbox" id="menu-toggle" class="hidden peer" />

            <div class="flex justify-between items-center">
                <label for="menu-toggle" class="cursor-pointer text-white">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </label>

                <div class="flex items-center space-x-3">
                    <?php if(isset($_SESSION['user'])): ?>
                        <span class="text-sm truncate max-w-[120px]"><?= htmlspecialchars($_SESSION['name'] ?? 'User'); ?></span>
                        <a href="logout.php" class="btn-danger text-sm">Logout</a>
                    <?php else: ?>
                        <a href="login.php" class="btn-primary text-sm">Login</a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Mobile Menu Links -->
            <div class="hidden peer-checked:flex flex-col gap-2 bg-blue-800 rounded-lg p-2 mt-4 z-50 relative">
                <a href="index.php" class="px-4 py-2 rounded-lg text-center hover:bg-yellow-400 hover:text-blue-800 transition">Home</a>
                <a href="scholarship.php" class="px-4 py-2 rounded-lg text-center hover:bg-yellow-400 hover:text-blue-800 transition">Scholarship</a>
                <a href="gallery.php" class="px-4 py-2 rounded-lg text-center hover:bg-yellow-400 hover:text-blue-800 transition">Gallery</a>
                <a href="news.php" class="px-4 py-2 rounded-lg text-center hover:bg-yellow-400 hover:text-blue-800 transition">Notice</a>
                <a href="programmes.php" class="px-4 py-2 rounded-lg text-center hover:bg-yellow-400 hover:text-blue-800 transition">Programme</a>
                <a href="about.php" class="px-4 py-2 rounded-lg text-center hover:bg-yellow-400 hover:text-blue-800 transition">About Us</a>
            </div>
        </div>
    </div>
</div>

<?php else: ?>
<!-- 📄 Other Pages Header -->
<div class="sticky top-0 z-50 backdrop-blur-xl bg-white/70 border-b border-gray-200 shadow-sm relative flex justify-between items-center px-4 py-4">

    <!-- 🍔 Hamburger Menu -->
    <div class="relative">
        <input type="checkbox" id="menu-toggle" class="hidden peer" />
        <label for="menu-toggle" class="flex items-center justify-center w-12 h-12 rounded-2xl 
                                       bg-white border border-gray-200 shadow-sm hover:shadow-lg 
                                       text-gray-600 hover:text-white hover:bg-collegeblue 
                                       hover:border-collegeblue transition-all duration-300 cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                 stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </label>

        <!-- Dropdown Menu -->
        <div class="hidden peer-checked:flex flex-col absolute left-0 mt-2 w-56 bg-white rounded-2xl shadow-lg border border-gray-200 z-50 animate-fade-in">
            <a href="index.php" class="px-4 py-3 hover:bg-blue-100 rounded-t-2xl transition text-gray-700 font-medium">Home</a>
            <a href="scholarship.php" class="px-4 py-3 hover:bg-blue-100 transition text-gray-700 font-medium">Scholarship</a>
            <a href="gallery.php" class="px-4 py-3 hover:bg-blue-100 transition text-gray-700 font-medium">Gallery</a>
            <a href="news.php" class="px-4 py-3 hover:bg-blue-100 transition text-gray-700 font-medium">Notice</a>
            <a href="programmes.php" class="px-4 py-3 hover:bg-blue-100 transition text-gray-700 font-medium">Programme</a>
            <a href="about.php" class="px-4 py-3 hover:bg-blue-100 rounded-b-2xl transition text-gray-700 font-medium">About Us</a>
        </div>
    </div>

    <!-- ➕ Add Button -->
    <?php 
    $skip_mobile_pages = ['gallery.php', 'scholarship.php', 'news.php']; // only disable mobile button on these pages

    if (
        $add_link &&
        isset($_SESSION['role']) &&
        in_array($_SESSION['role'], ['admin','teacher','professor','principal','director'])
    ) {
        $show_mobile = !in_array($current_page, $skip_mobile_pages); // hide floating + for these pages
        add_button($add_link, 'Add', $show_mobile);
    }
    ?>
</div>
<?php endif; ?>

</header>
