<?php
include 'db.php';
include 'navigation.php';
include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home - Jehal Prasad Teachers Training College</title>

  <!-- Common CSS -->
  <link rel="stylesheet" href="styles.css">

  <!-- Page-specific CSS -->
  <style>
    body {
      background-color: white;
    }

    .about-container {
      flex: 1;
      width: min(1100px, 95%);
      margin: 100px auto 40px;
      padding: 40px 30px;
      background: white;
      border-radius: 10px;
      box-shadow: 0 3px 10px rgba(0,0,0,0.1);
      color: #09080c;
      line-height: 1.7;
    }

    .about-container h1 {
      text-align: center;
      color: #004080;
      margin-bottom: 25px;
      font-size: 28px;
    }

    .about-container p {
      margin-bottom: 18px;
      font-size: 16px;
      text-align: justify;
    }

    strong {
      color: #004080;
    }

    hr {
      margin: 40px 0;
      border: 0;
      border-top: 1px solid #ccc;
    }

    h4 {
      text-align: center;
      font-style: italic;
      color: #004080;
    }

    /* Responsive Adjustments */
    @media (max-width: 1024px) {
      .about-container {
        padding: 30px 20px;
      }
      .about-container h1 {
        font-size: 26px;
      }
    }

    @media (max-width: 768px) {
      .about-container {
        margin: 80px 15px 30px;
        padding: 25px 18px;
      }
      .about-container h1 {
        font-size: 22px;
      }
      .about-container p {
        font-size: 15px;
      }
    }

    @media (max-width: 480px) {
      .about-container {
        margin: 70px 10px 20px;
        padding: 20px 15px;
      }
      .about-container h1 {
        font-size: 20px;
      }
      .about-container p {
        font-size: 14px;
      }
    }
  </style>
</head>

<body>

  <main class="about-container">
    <h1>Welcome to Jehal Prasad Teachers Training College</h1>

    <p>
      Jehal Prasad Teachers Training College is affiliated with 
      <strong>Magadh University, Bodhgaya</strong> and approved by the 
      <strong>National Council for Teacher Education (NCTE)</strong>.
      The college offers a two-year full-time <strong>Bachelor of Education (B.Ed.)</strong> program 
      with an intake capacity of 50 students. Our institution is dedicated to fostering academic 
      excellence, professional competence, and social responsibility in aspiring educators.
    </p>

    <p>
      Our vision and mission revolve around preparing dedicated teachers who not only excel in pedagogy 
      but also uphold strong moral and ethical values. We strive to cultivate reflective thinkers and 
      compassionate leaders who contribute meaningfully to the field of education and to society at large. 
      By integrating modern teaching methodologies with traditional principles, we aim to inspire future 
      educators to lead with knowledge, empathy, and integrity.
    </p>

    <p>
      With well-equipped facilities, experienced faculty, and a supportive learning environment, 
      Jehal Prasad Teachers Training College stands committed to empowering students to reach 
      their full potential as teachers, innovators, and lifelong learners.
    </p>

    <hr>

    <h4>“Empowering Teachers, Enriching Education, Enlightening Society.”</h4>
  </main>

  <?php include 'footer.php'; ?>
</body>
</html>
