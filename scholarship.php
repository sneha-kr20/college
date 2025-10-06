<?php
include 'db.php';
include 'navigation.php';
include 'header.php';

$searchTerm = strtolower($_GET['search'] ?? '');

$query = "SELECT * FROM scholarship";
if ($searchTerm !== '') {
    $query .= " WHERE LOWER(name) LIKE '%" . $conn->real_escape_string($searchTerm) . "%'";
}
$query .= " ORDER BY name ASC";

$allStudents = $conn->query($query);
$isPrivileged = isset($_SESSION['role']) && in_array($_SESSION['role'], ['admin', 'professor']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Scholarship Students - Jehal Prasad Teachers Training College</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: white;
      margin: 0;
      padding: 0;
      display: flex;
      flex-direction: column;
      align-items: center;
      min-height: 100vh;
    }

    /* Main container */
    main.scholarship-container {
      flex: 1;
      width: 100%;
      max-width: 1200px;
      margin: 80px auto 40px;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 20px;
      padding: 0 15px;
      box-sizing: border-box;
    }

    /* Search bar */
    .search-box {
      grid-column: 1 / -1;
      text-align: center;
      margin-bottom: 20px;
    }

    .search-box form {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 5px;
      width: 100%;
      max-width: 400px;
    }

    .search-box input[type="text"] {
      flex: 1;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      outline: none;
      font-size: 14px;
    }

    .search-box button {
      padding: 10px 15px;
      background-color: #004080;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-weight: bold;
    }

    .search-box button:hover {
      background-color: #0066cc;
    }

    /* Add Student button */
    .add-link {
      grid-column: 1 / -1;
      display: inline-block;
      margin: 0 auto 20px auto;
      text-align: center;
      background-color: #004080;
      color: white;
      padding: 10px 20px;
      text-decoration: none;
      border-radius: 6px;
      font-weight: bold;
      transition: background 0.3s;
    }

    .add-link:hover {
      background-color: #0066cc;
    }

    /* Student cards */
    .student-card {
      display: flex;
      flex-direction: column;
      align-items: flex-start;
      justify-content: flex-start;
      border: 1px solid #ccc;
      border-radius: 10px;
      padding: 15px;
      background-color: #fefefe;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      transition: transform 0.2s;
      box-sizing: border-box;
    }

    .student-card:hover {
      transform: translateY(-3px);
    }

    .student-card h3 {
      font-size: 18px;
      color: #004080;
      margin-bottom: 8px;
      text-align: left;
    }

    .student-card p {
      font-size: 14px;
      margin: 4px 0;
      line-height: 1.4;
      word-wrap: break-word;
      width: 100%;
    }

    /* Footer consistency */
    .site-footer {
      width: 100%;
      background-color: rgba(0, 64, 128, 0.95);
      color: white;
      padding: 20px 10px;
      text-align: center;
      border-top-left-radius: 10px;
      border-top-right-radius: 10px;
      box-sizing: border-box;
      margin-top: auto;
      font-size: 14px;
    }

    .site-footer a {
      color: #ffeb3b;
      text-decoration: none;
      font-weight: 600;
      margin: 0 5px;
    }

    .site-footer a:hover {
      color: #ffffff;
      text-decoration: underline;
    }

    /* Responsive */
    @media (max-width: 768px) {
      main.scholarship-container {
        grid-template-columns: 1fr;
      }

      .student-card {
        padding: 12px;
      }

      .student-card h3 {
        font-size: 16px;
      }

      .student-card p {
        font-size: 13px;
      }
    }

    @media (max-width: 480px) {
      .search-box form {
        flex-direction: column;
        gap: 8px;
        width: 90%;
      }

      .search-box input[type="text"] {
        width: 100%;
        border-radius: 5px;
      }

      .search-box button {
        width: 100%;
        border-radius: 5px;
      }

      .site-footer {
        padding: 18px 8px;
        font-size: 13px;
      }
    }
  </style>
</head>
<body>

<main class="scholarship-container">

  <!-- Search bar -->
  <div class="search-box">
    <form method="GET" action="">
      <input type="text" name="search" placeholder="Search student name..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
      <button type="submit">Search</button>
    </form>
  </div>

  <!-- Add Student button (for privileged users only) -->
  <?php if ($isPrivileged): ?>
    <a href="scholarship_add.php" class="add-link">+ Add New Student</a>
  <?php endif; ?>

  <!-- Scholarship cards -->
  <?php if ($allStudents && $allStudents->num_rows > 0): ?>
    <?php while ($row = $allStudents->fetch_assoc()): ?>
      <div class="student-card">
        <h3><?= htmlspecialchars($row['name']) ?></h3>
        <p><strong>Registration No:</strong> <?= htmlspecialchars($row['registration_id'] ?? '-') ?></p>
        <p><strong>Programme:</strong> <?= htmlspecialchars($row['programme']) ?></p>
        <p><strong>Batch:</strong> <?= htmlspecialchars($row['batch']) ?></p>
        <p><strong>Year:</strong> <?= htmlspecialchars($row['year']) ?></p>
        <p><strong>Amount:</strong> ₹<?= number_format($row['amount'], 2) ?></p>
        <p><strong>Added On:</strong> <?= htmlspecialchars($row['added_on'] ?? '-') ?></p>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <div class="student-card">
      <p style="text-align:center;">No scholarship students found.</p>
    </div>
  <?php endif; ?>

</main>

<?php include 'footer.php'; ?>
</body>
</html>
