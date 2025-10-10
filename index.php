
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
  <title>Home - Jehal Prasad Teachers Training College</title>
</head>

<body class="bg-gray-50 text-gray-800">

  <!-- Hero Section -->
  <section class="bg-white shadow-lg rounded-b-3xl relative">
    <div class="max-w-7xl mx-auto px-6 py-12 md:py-20 flex flex-col md:flex-row items-center gap-8">
      
      <!-- Logo -->
      <div class="flex-shrink-0">
        <img src="images/logo.png" alt="College Logo" class="h-24 w-24 md:h-32 md:w-32 rounded-full shadow-md animate-float">
      </div>

      <!-- College Name & Intro -->
      <div class="text-center md:text-left space-y-4">
        <h1 class="text-3xl md:text-5xl font-bold text-blue-900 leading-tight">
          Jehal Prasad Teachers Training College
        </h1>
        <p class="text-gray-700 text-base md:text-lg max-w-xl">
          Affiliated with <strong>Magadh University, Bodhgaya</strong> and approved by the 
          <strong>National Council for Teacher Education (NCTE)</strong>. Offering a two-year full-time 
          <strong>Bachelor of Education (B.Ed.)</strong> program with an intake of 50 students.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 mt-4 justify-center md:justify-start">
  <a href="about.php" class="btn-primary text-center">Learn More</a>
  <a href="contact.php" class="btn-primary bg-gradient-to-r from-yellow-400 to-blue-500 hover:from-yellow-500 hover:to-blue-600">Contact Us</a>
        </div>
      </div>

    </div>
  </section>

  <!-- About & Vision -->
  <section class="max-w-6xl mx-auto mt-16 px-6 space-y-12">
    
    <div class="bg-white p-8 md:p-12 rounded-2xl shadow-lg">
      <h2 class="text-2xl md:text-3xl font-bold text-blue-900 mb-4">Our Vision & Mission</h2>
      <p class="text-gray-700 text-base md:text-lg leading-relaxed">
        We aim to prepare dedicated teachers who excel in pedagogy while upholding strong moral and ethical values. 
        Our programs cultivate reflective thinkers and compassionate leaders who contribute meaningfully to the field of education.
      </p>
    </div>

    <div class="bg-white p-8 md:p-12 rounded-2xl shadow-lg">
      <h2 class="text-2xl md:text-3xl font-bold text-blue-900 mb-4">Why Choose Us?</h2>
      <ul class="list-disc list-inside text-gray-700 space-y-2">
        <li>Experienced and dedicated faculty.</li>
        <li>Well-equipped classrooms and labs.</li>
        <li>Modern teaching methods blended with tradition.</li>
        <li>Supportive learning environment.</li>
        <li>Holistic development of future educators.</li>
      </ul>
    </div>

    <div class="text-center mt-12">
      <h3 class="text-2xl md:text-3xl font-extrabold text-center bg-clip-text text-transparent 
           bg-gradient-to-r from-yellow-400 via-blue-500 to-pink-500 
           drop-shadow-lg animate-fade-in">
  “Empowering Teachers, Enriching Education, Enlightening Society.”
</h3>

    </div>

  </section>

  <?php include 'footer.php'; ?>

</body>
</html>
