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
  <title>Programmes - Jehal Prasad Teachers Training College</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    /* ===== PROGRAMMES PAGE ===== */
    body {
      background-color: white;
    }

    .programmes-container {
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

    .programmes-container h1 {
      text-align: center;
      color: #004080;
      margin-bottom: 25px;
      font-size: 28px;
    }

    .programmes-container h2 {
      color: #004080;
      margin-top: 25px;
      margin-bottom: 10px;
      font-size: 22px;
      border-left: 4px solid #004080;
      padding-left: 10px;
    }

    .programmes-container p, 
    .programmes-container ul {
      margin-bottom: 18px;
      font-size: 16px;
      text-align: justify;
    }

    .programmes-container ul li {
      margin-bottom: 10px;
    }

    strong, b {
      color: #004080;
    }
  </style>
</head>
<body>

<main class="programmes-container">
  <h1>Programmes Offered</h1>

  <p>
    Jehal Prasad Teachers Training College offers professional teacher education programs designed to prepare competent and ethical educators for schools. Our programs combine theoretical knowledge, practical training, and community engagement to ensure holistic development of future teachers.
  </p>

  <ul>
    <li><b>Bachelor of Education (B.Ed.)</b> – A two-year full-time program approved by <b>NCTE</b> and affiliated with <b>Magadh University, Bodhgaya</b>. The program aims to equip students with modern pedagogical skills, educational psychology knowledge, and practical teaching experience.</li>
    <!-- Additional programs can be added here in the future -->
  </ul>
</main>

<?php include 'footer.php';?>
</body>
</html>
