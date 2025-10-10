<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'db.php';
include 'tailwind.php';
include 'components.php';
include 'header.php';

// Search
$searchTerm = strtolower(trim($_GET['search'] ?? ''));

// Pagination variables
$perPage = 10; // students per page
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $perPage;

// Count total records for pagination
$countSql = "SELECT COUNT(*) as total FROM scholarship";
if ($searchTerm !== '') {
    $countSql .= " WHERE LOWER(name) LIKE ?";
    $stmtCount = $conn->prepare($countSql);
    $likeTerm = "%$searchTerm%";
    $stmtCount->bind_param("s", $likeTerm);
    $stmtCount->execute();
    $totalResult = $stmtCount->get_result()->fetch_assoc();
    $stmtCount->close();
} else {
    $totalResult = $conn->query($countSql)->fetch_assoc();
}
$totalRecords = $totalResult['total'];
$totalPages = ceil($totalRecords / $perPage);

// Fetch current page records
if ($searchTerm !== '') {
    $stmt = $conn->prepare("SELECT * FROM scholarship WHERE LOWER(name) LIKE ? ORDER BY name ASC LIMIT ? OFFSET ?");
    $stmt->bind_param("sii", $likeTerm, $perPage, $offset);
} else {
    $stmt = $conn->prepare("SELECT * FROM scholarship ORDER BY name ASC LIMIT ? OFFSET ?");
    $stmt->bind_param("ii", $perPage, $offset);
}
$stmt->execute();
$result = $stmt->get_result();

// Privileged roles
$allowed_roles = ['admin','teacher','professor','principal','director'];
$isPrivileged = isset($_SESSION['role']) && in_array($_SESSION['role'], $allowed_roles);

// Add link for mobile floating button
$add_link = 'scholarship_add.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Scholarship Students - Jehal Prasad TTC</title>
</head>
<body class="min-h-screen flex flex-col font-sans text-gray-800">

<div class="max-w-7xl mx-auto px-4 py-10">

<!-- Heading -->
  <div class="text-center mb-10 fade-in-up relative">
    <h1 class="text-4xl md:text-5xl font-extrabold text-collegeblue tracking-tight animate-zoom-pulse">
      Scholarship Students
    </h1>
    <div class="mt-3">
      <div class="h-1 w-20 mx-auto bg-gradient-to-r from-yellow-400 to-orange-500 rounded-full"></div>
      <div class="h-0.5 w-10 mx-auto bg-blue-500/70 mt-1 rounded-full"></div>
    </div>
  </div>

  <!-- Search -->
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
          <th class="px-4 py-2 text-left">Amount (₹)</th>
          <th class="px-4 py-2 text-left">Added On</th>
          <?php if($isPrivileged): ?><th class="px-4 py-2 text-left">Delete</th><?php endif; ?>
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
              <td class="px-4 py-2">₹<?= number_format($row['amount'], 2) ?></td>
              <td class="px-4 py-2"><?= htmlspecialchars($row['created_at'] ?? '-') ?></td>
              <?php if($isPrivileged): ?>
              <td class="px-4 py-2">
                <a href="delete.php?type=scholarship&id=<?= $row['id'] ?>" 
                   onclick="return confirm('Are you sure you want to delete this student?');"
                   class="text-red-600 font-bold hover:text-red-800">×</a>
              </td>
              <?php endif; ?>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="<?= $isPrivileged ? 7 : 6 ?>" class="text-center py-6 text-gray-500">No students found.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <!-- Mobile Cards -->
  <div class="md:hidden space-y-4">
    <?php $result->data_seek(0); while($row = $result->fetch_assoc()): ?>
      <div class="glass-card rounded-3xl border border-gray-100 shadow-md hover-lift p-4 relative">
        <input type="checkbox" id="toggle-<?= $row['id'] ?>" class="peer hidden">
        <label for="toggle-<?= $row['id'] ?>" class="flex justify-between items-center cursor-pointer">
          <h3 class="font-semibold text-collegeblue"><?= htmlspecialchars($row['name']) ?></h3>
          <span class="text-collegeblue font-bold text-lg transition-transform duration-300 peer-checked:rotate-45">+</span>
        </label>

        <div class="mt-2 text-sm space-y-1 max-h-0 overflow-hidden transition-all duration-500 peer-checked:max-h-96">
          <p><strong>Reg. No:</strong> <?= htmlspecialchars($row['registration_id'] ?? '-') ?></p>
          <p><strong>Programme:</strong> <?= htmlspecialchars($row['programme']) ?></p>
          <p><strong>Batch:</strong> <?= htmlspecialchars($row['batch']) ?></p>
          <p><strong>Amount:</strong> ₹<?= number_format($row['amount'], 2) ?></p>
          <p><strong>Added On:</strong> <?= htmlspecialchars($row['created_at'] ?? '-') ?></p>

          <?php if($isPrivileged): ?>
          <a href="delete.php?type=scholarship&id=<?= $row['id'] ?>" 
             onclick="return confirm('Are you sure you want to delete this student?');"
             class="inline-block mt-3 w-full text-center bg-red-500 text-white font-semibold py-2 rounded-lg hover:bg-red-600 transition">
            × Delete
          </a>
          <?php endif; ?>
        </div>
      </div>
    <?php endwhile; ?>
  </div>

  <!-- Pagination -->
  <div class="flex justify-center items-center gap-2 mt-6">
    <?php if($page > 1): ?>
        <a href="?page=<?= $page - 1 ?>&search=<?= urlencode($_GET['search'] ?? '') ?>" 
           class="px-4 py-2 bg-collegeblue text-white rounded-full hover:bg-blue-800 transition">Prev</a>
    <?php endif; ?>

    <span class="px-3 py-2 text-gray-700 font-medium">Page <?= $page ?> of <?= $totalPages ?></span>

    <?php if($page < $totalPages): ?>
        <a href="?page=<?= $page + 1 ?>&search=<?= urlencode($_GET['search'] ?? '') ?>" 
           class="px-4 py-2 bg-collegeblue text-white rounded-full hover:bg-blue-800 transition">Next</a>
    <?php endif; ?>
  </div>

</div>

<!-- Mobile Floating Add Button ONLY -->
<?php if($isPrivileged): ?>
  <a href="<?= htmlspecialchars($add_link) ?>" 
     class="fixed bottom-6 right-6 sm:hidden z-50 inline-flex items-center justify-center w-14 h-14 bg-collegeblue text-white rounded-full shadow-lg hover:shadow-xl hover:bg-blue-800 transition-all duration-300">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-7 h-7">
      <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
    </svg>
  </a>
<?php endif; ?>

</body>
</html>
