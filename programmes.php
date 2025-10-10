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
  <title>Programmes - Jehal Prasad Teachers Training College</title>
</head>
<body class="bg-gray-50 font-sans text-gray-900">

  <!-- Programmes Page Container -->
  <main class="max-w-6xl mx-auto my-24 p-6 md:p-12 rounded-3xl bg-white shadow-glow">

    
  <!-- Heading -->
  <div class="text-center mb-10 fade-in-up relative">
    <h1 class="text-4xl md:text-5xl font-extrabold text-collegeblue tracking-tight animate-zoom-pulse">
      Our Programme
    </h1>
    <div class="mt-3">
      <div class="h-1 w-20 mx-auto bg-gradient-to-r from-yellow-400 to-orange-500 rounded-full"></div>
      <div class="h-0.5 w-10 mx-auto bg-blue-500/70 mt-1 rounded-full"></div>
    </div>
  </div>

    <!-- Introduction -->
    <p class="mb-6 text-gray-800 text-lg md:text-xl leading-relaxed">
      Jehal Prasad Teachers Training College offers professional teacher education programs designed to prepare competent and ethical educators for schools. 
      Our programs combine theoretical knowledge, practical training, and community engagement to ensure holistic development of future teachers.
    </p>

    <!-- Programme List Section -->
    <div class="grid md:grid-cols-1 gap-8 mb-10">
      <!-- B.Ed. Programme Card -->
      <div class="glass-card p-6 shadow-glow hover:shadow-xl transition-all duration-500">
        <h2 class="text-2xl font-bold text-collegeblue mb-4">Bachelor of Education (B.Ed.)</h2>
        <p class="text-gray-800 text-lg leading-relaxed mb-2">
          A two-year full-time program approved by 
          <strong class="text-collegeblue">NCTE</strong> and affiliated with 
          <strong class="text-collegeblue">Magadh University, Bodhgaya</strong>.
        </p>
        <p class="text-gray-800 text-lg leading-relaxed">
          The program aims to equip students with modern pedagogical skills, educational psychology knowledge, and practical teaching experience.
          It integrates classroom learning, teaching internships, and seminars to develop future educators who are both skilled and socially responsible.
        </p>
      </div>
    </div>

    <!-- Key Highlights -->
    <div class="grid md:grid-cols-2 gap-8 mb-10">
      <div class="glass-card p-6 shadow-glow hover:shadow-xl transition-all duration-500">
        <h2 class="text-2xl font-bold text-collegeblue mb-4">Why Choose Our Programme?</h2>
        <ul class="list-disc list-inside text-gray-800 text-lg space-y-2">
          <li>Approved by <strong class="text-collegeblue">National Council for Teacher Education (NCTE)</strong></li>
          <li>Affiliated to <strong class="text-collegeblue">Magadh University, Bodhgaya</strong></li>
          <li>Experienced and dedicated faculty members</li>
          <li>Modern infrastructure and digital classrooms</li>
          <li>Focus on both theory and practical teaching methods</li>
        </ul>
      </div>

      <div class="glass-card p-6 shadow-glow hover:shadow-xl transition-all duration-500">
        <h2 class="text-2xl font-bold text-collegeblue mb-4">Programme Duration & Intake</h2>
        <p class="text-gray-800 text-lg leading-relaxed">
          The <strong class="text-collegeblue">B.Ed.</strong> program is a 
          <strong class="text-collegeblue">two-year full-time</strong> course designed as per NCTE norms.
        </p>
        <p class="text-gray-800 text-lg mt-2">
          The approved intake capacity is <strong class="text-collegeblue">50 students</strong> per session.
        </p>
      </div>
    </div>

    <!-- Academic Focus -->
    <div class="glass-card p-6 shadow-glow hover:shadow-xl transition-all duration-500 mb-10">
      <h2 class="text-2xl font-bold text-collegeblue mb-4">Academic Focus & Curriculum</h2>
      <p class="text-gray-800 text-lg leading-relaxed mb-2">
        The curriculum emphasizes:
      </p>
      <ul class="list-disc list-inside text-gray-800 text-lg space-y-2">
        <li>Understanding learner psychology and pedagogy of school subjects</li>
        <li>Developing communication and classroom management skills</li>
        <li>Integrating ICT tools for effective teaching-learning</li>
        <li>Community participation and field engagement activities</li>
        <li>Practice teaching through internship programs</li>
      </ul>
    </div>

    <!-- Back to Home Button -->
    <div class="text-center mt-12">
      <a href="index.php" class="inline-block px-8 py-3 rounded-full bg-gradient-to-r from-blue-600 to-collegeblue 
             text-white font-semibold shadow-lg hover:from-blue-700 hover:to-blue-900 transform hover:scale-105 transition-all duration-300">
        ← Back to Home
      </a>
    </div>

  </main>
</body>
</html>
