<?php
session_start();
$current_page = basename($_SERVER['PHP_SELF']); // detect current file
?>
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- ===== Header ===== -->
<header class="header-container">

    <?php if ($current_page === 'index.php'): ?>
        <!-- ===== HOME PAGE HEADER (Logo + College Name + Navigation) ===== -->
        <div class="logo-container">
            <img src="images/name.png" alt="College Logo" class="logo">
        </div>

        <div class="right-container">
            <!-- College Name -->
            <div class="college-header">
                <h1>Jehal Prasad Teachers Training College</h1>
            </div>

            <!-- Navigation (normal flow, sits directly below college name) -->
            <nav class="main-nav">
                <div class="nav-links">
                    <a href="index.php">Home</a>
                    <a href="scholarship.php">Scholarships</a>
                    <a href="gallery.php">Gallery</a>
                    <a href="news.php">Notice Board</a>
                    <a href="programmes.php">Programmes</a>
                    <a href="about.php">About Us</a>
                </div>
                <div class="nav-auth">
                    <?php if (isset($_SESSION['user'])): ?>
                        <?= $_SESSION['name']; ?> |
                        <a href="logout.php">Logout</a>
                    <?php else: ?>
                        <a href="login.php">Login</a>
                    <?php endif; ?>
                </div>
            </nav>
        </div>

    <?php else: ?>
        <!-- ===== OTHER PAGES HEADER (Only Navigation, fixed at top) ===== -->
        <nav class="main-nav fixed-nav">
            <div class="nav-links">
                <a href="index.php">Home</a>
                <a href="scholarship.php">Scholarships</a>
                <a href="gallery.php">Gallery</a>
                <a href="news.php">Notice Board</a>
                <a href="programmes.php">Programmes</a>
                <a href="about.php">About Us</a>
            </div>
            <div class="nav-auth">
                <?php if (isset($_SESSION['user'])): ?>
                    <?= $_SESSION['name']; ?> |
                    <a href="logout.php">Logout</a>
                <?php else: ?>
                    <a href="login.php">Login</a>
                <?php endif; ?>
            </div>
        </nav>
    <?php endif; ?>
<!-- ===== Modal Login Form ===== -->
<div id="loginModal" class="modal" style="display:none;">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>User Login</h2>
        <form method="POST" action="login.php">
            <input type="text" name="registration_id" placeholder="Registration ID" required><br><br>
            <input type="password" name="password" placeholder="Password" required><br><br>
            <button type="submit">Login</button>
        </form>
        <p><a href="reset_password.php">Forgot Password?</a></p>
    </div>
</div>

</header>

<div class="container">
<!-- Page Content Starts Here -->
