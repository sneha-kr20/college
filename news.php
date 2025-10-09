<?php
include 'db.php';
include 'navigation.php';
include 'header.php';

$result = $conn->query("SELECT * FROM news ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Notice Board</title>
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

    main.notice-container {
      flex: 1;
      width: 100%;
      max-width: 1200px;
      margin: 80px auto 40px;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 20px;
      padding: 0 15px;
      box-sizing: border-box;
    }

    .notice {
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      padding: 20px 25px;
      border-radius: 10px;
      border: 1px solid #ccc;
      background-color: #fefefe;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      box-sizing: border-box;
      transition: transform 0.2s;
    }

    .notice:hover {
      transform: translateY(-3px);
    }

    .notice h3 {
      font-size: 18px;
      margin-bottom: 10px;
      color: #004080;
      text-align: left;
    }

    .notice p {
      font-size: 15px;
      margin-bottom: 8px;
      text-align: left;
    }

    .notice small {
      color: #666;
      font-size: 13px;
    }

    .notice a {
      color: #007BFF;
      text-decoration: none;
      font-size: 14px;
    }

    .notice a:hover {
      text-decoration: underline;
    }

    .add-notice {
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
    }

    .add-notice:hover {
      background-color: #0066cc;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
      main.notice-container {
        grid-template-columns: 1fr;
      }
      .notice h3 { font-size: 16px; }
      .notice p { font-size: 14px; }
    }

    @media (max-width: 480px) {
      main.notice-container {
        padding: 0 10px;
      }
      .notice {
        padding: 15px;
      }
      .notice h3 { font-size: 15px; }
      .notice p { font-size: 13px; }
    }

    /* ===========================
       FOOTER STYLING
    ============================ */
    .site-footer {
      width: 100%;                  /* Full width */
      background-color: rgba(0, 64, 128, 0.95);
      color: white;
      padding: 1px 10px;           /* Taller padding for visibility */
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
      font-weight: 550;
      margin: 0 5px;
    }

    .site-footer a:hover {
      color: #ffffff;
      text-decoration: underline;
    }
  </style>
</head>
<body>

<main class="notice-container">

  <?php
  if (isset($_SESSION['role']) && in_array($_SESSION['role'], ['admin','teacher','professor','principal','director'])): ?>
    <a href="news_add.php" class="add-notice">+ Add New Notice</a>
  <?php endif; ?>

  <?php while($row = $result->fetch_assoc()): ?>
    <div class="notice">
      <h3><?= htmlspecialchars($row['title']) ?></h3>
      <p><?= nl2br(htmlspecialchars($row['content'])) ?></p>

      <?php if(!empty($row['file_path'])): ?>
        <p>Attachment: <a href="<?= $row['file_path'] ?>" target="_blank">View File</a></p>
      <?php endif; ?>

      <small>Posted on: <?= $row['created_at'] ?></small><br>
      <a href="https://wa.me/?text=<?= urlencode($row['title'].' - '.$row['content']); ?>" target="_blank">
        Share on WhatsApp
      </a>
    </div>
  <?php endwhile; ?>

</main>

<?php include 'footer.php'; ?>
</body>
</html>
