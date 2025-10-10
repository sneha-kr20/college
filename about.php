<?php
include 'db.php';
include 'navigation.php';
include 'header.php';
include 'tailwind.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About Us - Jehal Prasad Teachers Training College</title>
</head>
<body class="bg-gray-50 font-sans text-gray-900">

  <!-- About Page Container -->
  <main class="max-w-6xl mx-auto my-24 p-6 md:p-12 rounded-3xl bg-white shadow-glow">

    <!-- Heading -->
    <h1 class="text-3xl md:text-5xl font-extrabold text-collegeblue text-center mb-10 
               animate-fade-in page-heading-glow">
      About Jehal Prasad Teachers Training College
    </h1>

    <!-- Description -->
    <p class="mb-6 text-gray-800 text-lg md:text-xl leading-relaxed">
      Jehal Prasad Teachers Training College, located in <strong class="text-collegeblue">Nawada, Bihar</strong>, is affiliated with 
      <strong class="text-collegeblue">Magadh University, Bodhgaya</strong> and approved by the 
      <strong class="text-collegeblue">National Council for Teacher Education (NCTE)</strong>.  
      We offer a full-time <strong class="text-collegeblue">Bachelor of Education (B.Ed.)</strong> program with an intake of 50 students.
    </p>

    <p class="mb-8 text-gray-800 text-lg md:text-xl leading-relaxed">
      Our college combines modern teaching methods with ethical principles, supported by a dedicated faculty, state-of-the-art campus facilities, and a mission to cultivate reflective and competent educators.
    </p>

    <!-- Vision & Mission Cards -->
    <div class="grid md:grid-cols-2 gap-8 mb-10">
      <!-- Vision Card -->
      <div class="glass-card p-6 shadow-glow hover:shadow-xl transition-all duration-500">
        <h2 class="text-2xl font-bold text-collegeblue mb-4">Our Vision</h2>
        <p class="text-gray-800 text-lg leading-relaxed">
          To be a center of excellence in teacher education, nurturing intellectual curiosity, integrity, and social responsibility.  
          We aim to produce educators who inspire, lead, and contribute positively to society.
        </p>
      </div>

      <!-- Mission Card -->
      <div class="glass-card p-6 shadow-glow hover:shadow-xl transition-all duration-500">
        <h2 class="text-2xl font-bold text-collegeblue mb-4">Our Mission</h2>
        <p class="text-gray-800 text-lg leading-relaxed">
          To provide high-quality teacher education grounded in pedagogy, ethics, and experiential learning.  
          Our programs encourage innovation, critical thinking, reflective practice, and community engagement.
        </p>
      </div>
    </div>

    <!-- Fee & College Hours -->
    <div class="grid md:grid-cols-2 gap-8 mb-10">
      <div class="glass-card p-6 shadow-glow hover:shadow-xl transition-all duration-500">
        <h2 class="text-2xl font-bold text-collegeblue mb-4">Fee & Affordability</h2>
        <p class="text-gray-800 text-lg">
          The annual fee for the B.Ed. program is <strong class="text-collegeblue">₹ 40,000</strong>, in accordance with official Bihar B.Ed. admission guidelines.
        </p>
      </div>

      <div class="glass-card p-6 shadow-glow hover:shadow-xl transition-all duration-500">
        <h2 class="text-2xl font-bold text-collegeblue mb-4">College Hours & Contact</h2>
        <p class="text-gray-800 text-lg">
          The institute operates from <strong class="text-collegeblue">8:00 AM to 4:00 PM</strong> on working days.
        </p>
      </div>
    </div>

    <!-- Back to Home Button -->
    <div class="text-center mt-12">
      <a href="index.php" class="inline-block px-8 py-3 rounded-full bg-gradient-to-r from-blue-600 to-collegeblue 
             text-white font-semibold shadow-lg hover:from-blue-700 hover:to-blue-900 transform hover:scale-105 transition-all duration-300">
        ← Back to Home
      </a>
    </div>

  </main>

  <?php include 'footer.php'; ?>
</body>
</html>
