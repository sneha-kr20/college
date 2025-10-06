<?php
include 'db.php';
include 'navigation.php';
include 'header.php';

$result = $conn->query("SELECT * FROM gallery ORDER BY uploaded_at DESC");
if (!$result) {
    die("Database query failed: " . $conn->error);
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gallery - Jehal Prasad Teachers Training College</title>
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

    /* Container for gallery items */
    main.gallery-container {
      flex: 1;
      width: 100%;
      max-width: 1200px;
      margin: 80px auto 40px;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
      padding: 0 15px;
      box-sizing: border-box;
    }

    .gallery-item {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: flex-start;
      border-radius: 10px;
      border: 1px solid #ccc;
      background-color: #fefefe;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      padding: 15px;
      box-sizing: border-box;
      transition: transform 0.2s;
    }

    .gallery-item:hover {
      transform: translateY(-3px);
    }

    .gallery-image {
      width: 100%;
      height: 180px;
      object-fit: cover;
      border-radius: 8px;
      margin-bottom: 8px;
    }

    .gallery-caption {
      font-size: 14px;
      color: #004080;
      text-align: center;
      width: 100%;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
    }

    /* Add Image button */
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
    }

    .add-link:hover {
      background-color: #0066cc;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
      main.gallery-container {
        grid-template-columns: 1fr; /* stack vertically */
      }
    }

    @media (max-width: 480px) {
      main.gallery-container {
        padding: 0 10px;
      }
      .gallery-item {
        padding: 10px;
      }
      .gallery-image {
        height: 150px;
      }
      .gallery-caption {
        font-size: 13px;
      }
    }

    /* ===========================
       FOOTER STYLING
    ============================ */
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
  </style>
</head>
<body>

<main class="gallery-container">

  <?php if (isset($_SESSION['role']) && in_array($_SESSION['role'], ['admin','teacher','professor','principal','director'])): ?>
    <a href="gallery_add.php" class="add-link">+ Add New Image</a>
  <?php endif; ?>

  <?php while($row = $result->fetch_assoc()): ?>
    <div class="gallery-item">
      <img src="<?= htmlspecialchars($row['image_path']) ?>" 
           alt="<?= htmlspecialchars($row['caption'] ?: 'Gallery image') ?>" 
           class="gallery-image">
      <span class="gallery-caption"><?= htmlspecialchars($row['caption']) ?></span>
    </div>
  <?php endwhile; ?>

</main>

<?php include 'footer.php'; ?>
</body>
</html>
