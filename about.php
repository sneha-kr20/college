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
  <title>About Us - Jehal Prasad Teachers Training College</title>
  
  <!-- Common CSS -->
  <link rel="stylesheet" href="styles.css">

  <!-- Page-specific CSS -->
  <style>
    /* ===== ABOUT PAGE STYLING ===== */
    body {
      background-color:white;
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

    .about-container h2 {
      color: #004080;
      margin-top: 25px;
      margin-bottom: 10px;
      font-size: 22px;
      border-left: 4px solid #004080;
      padding-left: 10px;
    }

    /* .about-container p {
      margin-bottom: 18px;
      font-size: 16px;
      text-align: justify;
    } */

    /* Highlighted text (like ₹40,000 or important terms) */
    strong {
      color: #004080;
    }

    /* === Responsive Adjustments ===
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
      .about-container h2 {
        font-size: 18px;
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
    } */
  </style>
</head>
<body>

  <main class="about-container">
    <h1>About Jehal Prasad Teachers Training College</h1>

    <p>
      Jehal Prasad Teachers Training College, located in Nawada, Bihar, is affiliated with 
      <strong>Magadh University, Bodhgaya</strong> and approved by the 
      <strong>National Council for Teacher Education (NCTE)</strong>.
      We offer a full-time <strong>Bachelor of Education (B.Ed.)</strong> program with an intake capacity of 
      <strong>50 students</strong>. The B.Ed. program spans 24 months and aims to prepare educators for modern school challenges.
    </p>

    <p>
      Our student body is approximately 59 learners, supported by a dedicated faculty of about 16 members.  
      The campus, covering roughly 1 acre, includes facilities such as a library, laboratories, classrooms, IT infrastructure, auditorium, sports area, cafeteria, medical amenities, and parking.  
      We aim to foster a conducive environment for academic, professional, and personal growth.
    </p>

    <h2>Our Vision</h2>
    <p>
      Our vision is to be a center of excellence in teacher education that nurtures intellectual curiosity, integrity, and social responsibility.  
      We strive to produce teachers who inspire, lead, and contribute positively to educational development and society.
    </p>

    <h2>Our Mission</h2>
    <p>
      Our mission is to provide quality teacher education grounded in sound pedagogy, ethical values, and experiential learning.  
      We encourage innovation, critical thinking, reflective practice, and community engagement among our students.  
      By doing so, we hope to cultivate educators capable of shaping future generations with both knowledge and character.
    </p>

    <h2>Fee & Affordability</h2>
    <p>
      According to the official fee schedule published in the Bihar B.Ed. common admission document, the annual fee for the B.Ed. program at Jehal Prasad Teachers Training College is listed as 
      <strong>₹ 40,000</strong>.
    </p>

    <h2>College Hours & Contact</h2>
    <p>
      The institute generally operates from <strong>8:00 AM to 4:00 PM</strong> on working days, as per local listings.
    </p>
  </main>

  <?php include 'footer.php';?>
</body>
</html>
