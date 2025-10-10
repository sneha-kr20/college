<?php
session_start();
include 'db.php';
include 'tailwind.php';
include 'components.php'; // add_button()

$searchTerm = strtolower(trim($_GET['search'] ?? ''));
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;

// Get 4 most recent years
$yearsResult = $conn->query("SELECT DISTINCT year FROM scholarship ORDER BY year DESC LIMIT 4");
$years = [];
while ($r = $yearsResult->fetch_assoc()) { $years[] = $r['year']; }

$totalYears = count($years);
$currentYear = $years[$page - 1] ?? $years[0] ?? date('Y');

// Fetch scholarship students
if ($searchTerm !== '') {
    $stmt = $conn->prepare("
        SELECT * FROM scholarship 
        WHERE year = ? AND LOWER(name) LIKE CONCAT('%', ?, '%') 
        ORDER BY name ASC
    ");
    $stmt->bind_param("is", $currentYear, $searchTerm);
} else {
    $stmt = $conn->prepare("SELECT * FROM scholarship WHERE year = ? ORDER BY name ASC");
    $stmt->bind_param("i", $currentYear);
}
$stmt->execute();
$result = $stmt->get_result();

$isPrivileged = isset($_SESSION['role']) && in_array($_SESSION['role'], ['admin','professor','teacher','principal','director']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Scholarship Students</title>
</head>
<body class="min-h-screen flex flex-col font-sans text-gray-800 overflow-x-hidden
             bg-gradient-to-br from-blue-50 via-white to-yellow-50">

<!-- Sticky Header -->
<header class="sticky top-0 z-50 backdrop-blur-lg bg-white/70 border-b border-gray-200 shadow-sm">
  <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
    
    <!-- Back Button -->
    <a href="index.php"
       class="flex items-center justify-center w-12 h-12 rounded-2xl bg-white border border-gray-200 
              shadow-sm hover:shadow-md text-gray-600 hover:text-white hover:bg-collegeblue 
              transition-all duration-300">
       <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
         <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
       </svg>
    </a>

    <!-- Add Button (Desktop + Mobile handled inside function) -->
    <?php if ($isPrivileged): ?>
      <?php add_button('scholarship_add.php', '+ Add Student'); ?>
    <?php endif; ?>
  </div>
</header>

<div class="max-w-7xl mx-auto px-4 py-10">

  <!-- Heading -->
  <div class="text-center mb-10 fade-in-up relative">
    <h1 class="text-4xl md:text-5xl font-extrabold text-collegeblue tracking-tight animate-zoom-pulse">
      <!-- <span class="inline-block animate-float mr-2">🎓</span>  -->
       Scholarship Students
    </h1>
    <div class="mt-3">
      <div class="h-1 w-20 mx-auto bg-gradient-to-r from-yellow-400 to-orange-500 rounded-full"></div>
      <div class="h-0.5 w-10 mx-auto bg-blue-500/70 mt-1 rounded-full"></div>
    </div>
  </div>

  <!-- Search + Add button (redundant on header but kept for body) -->
  <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
    <form method="GET" class="flex flex-1 gap-2">
      <input type="text" name="search" placeholder="Search student name..."
        value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
        class="flex-1 border border-gray-300 rounded-md px-3 py-2 text-sm md:text-base focus:outline-none focus:ring-2 focus:ring-collegeblue">
      <button type="submit" class="bg-collegeblue text-white px-4 py-2 rounded-md hover:bg-blue-700 font-semibold">
        Search
      </button>
    </form>
  </div>

  <!-- Desktop Table -->
  <div class="hidden md:block overflow-x-auto fade-in-up glass-card rounded-3xl border border-gray-100 shadow-md p-6">
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-collegeblue text-white rounded-xl">
        <tr>
          <th class="px-4 py-2 text-left">Name</th>
          <th class="px-4 py-2 text-left">Registration No</th>
          <th class="px-4 py-2 text-left">Programme</th>
          <th class="px-4 py-2 text-left">Batch</th>
          <th class="px-4 py-2 text-left">Year</th>
          <th class="px-4 py-2 text-left">Amount (₹)</th>
          <th class="px-4 py-2 text-left">Added On</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200">
        <?php if ($result->num_rows > 0): ?>
          <?php while($row = $result->fetch_assoc()): ?>
            <tr>
              <td class="px-4 py-2"><?= htmlspecialchars($row['name']) ?></td>
              <td class="px-4 py-2"><?= htmlspecialchars($row['registration_id'] ?? '-') ?></td>
              <td class="px-4 py-2"><?= htmlspecialchars($row['programme']) ?></td>
              <td class="px-4 py-2"><?= htmlspecialchars($row['batch']) ?></td>
              <td class="px-4 py-2"><?= htmlspecialchars($row['year']) ?></td>
              <td class="px-4 py-2">₹<?= number_format($row['amount'], 2) ?></td>
              <td class="px-4 py-2"><?= htmlspecialchars($row['created_at'] ?? '-') ?></td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="7" class="text-center py-6 text-gray-500">No students found.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <!-- Mobile Cards -->
  <div class="md:hidden space-y-4">
    <?php $result->data_seek(0); while($row = $result->fetch_assoc()): ?>
      <div class="glass-card rounded-3xl border border-gray-100 shadow-md hover-lift p-4 relative">
        <!-- CSS-only toggle -->
        <input type="checkbox" id="toggle-<?= $row['id'] ?>" class="peer hidden">
        <label for="toggle-<?= $row['id'] ?>" class="flex justify-between items-center cursor-pointer">
          <h3 class="font-semibold text-collegeblue"><?= htmlspecialchars($row['name']) ?></h3>
          <span class="text-collegeblue font-bold text-lg transition-transform duration-300 peer-checked:rotate-45">+</span>
        </label>
        <div class="mt-2 text-sm space-y-1 max-h-0 overflow-hidden transition-all duration-500 peer-checked:max-h-96">
          <p><strong>Reg. No:</strong> <?= htmlspecialchars($row['registration_id'] ?? '-') ?></p>
          <p><strong>Programme:</strong> <?= htmlspecialchars($row['programme']) ?></p>
          <p><strong>Batch:</strong> <?= htmlspecialchars($row['batch']) ?></p>
          <p><strong>Year:</strong> <?= htmlspecialchars($row['year']) ?></p>
          <p><strong>Amount:</strong> ₹<?= number_format($row['amount'], 2) ?></p>
          <p><strong>Added On:</strong> <?= htmlspecialchars($row['created_at'] ?? '-') ?></p>
        </div>
      </div>
    <?php endwhile; ?>
  </div>

  <!-- Year Pagination (max 4 years) -->
  <div class="flex justify-center items-center gap-3 mt-10">
    <?php if ($page > 1): ?>
      <a href="?page=<?= $page - 1 ?>" 
         class="px-4 py-2 bg-collegeblue text-white rounded-full hover:bg-blue-800 transition">
         ← Older Year
      </a>
    <?php endif; ?>

    <span class="text-gray-700 font-medium">
      Page <?= $page ?> of <?= $totalYears ?>
    </span>

    <?php if ($page < $totalYears): ?>
      <a href="?page=<?= $page + 1 ?>" 
         class="px-4 py-2 bg-collegeblue text-white rounded-full hover:bg-blue-800 transition">
         Newer Year → 
      </a>
    <?php endif; ?>
  </div>

</div>
</body>
</html>
