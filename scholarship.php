<?php
include 'db.php';
include 'navigation.php';
include 'header.php';
include 'tailwind.php';

$searchTerm = strtolower(trim($_GET['search'] ?? ''));
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;

// Get all distinct years in descending order (newest first)
$yearsResult = $conn->query("SELECT DISTINCT year FROM scholarship ORDER BY year DESC");
$years = [];
while ($r = $yearsResult->fetch_assoc()) {
    $years[] = $r['year'];
}

// Determine the current year based on page
$totalYears = count($years);
$currentYear = $years[$page - 1] ?? $years[0] ?? date('Y');

// Fetch scholarship students for the current year
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

$isPrivileged = isset($_SESSION['role']) && in_array($_SESSION['role'], ['admin', 'professor']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Scholarship Students</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-white font-sans text-gray-900">

<div class="max-w-7xl mx-auto px-4 py-10">

  <!-- Search + Add button -->
  <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
    <form method="GET" class="flex flex-1 gap-2">
      <input type="text" name="search" placeholder="Search student name..."
        value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
        class="flex-1 border border-gray-300 rounded-md px-3 py-2 text-sm md:text-base focus:outline-none focus:ring-2 focus:ring-collegeblue">
      <button type="submit" class="bg-collegeblue text-white px-4 py-2 rounded-md hover:bg-blue-700 font-semibold">
        Search
      </button>
    </form>

    <?php if ($isPrivileged): ?>
      <a href="scholarship_add.php"
         class="bg-collegeblue text-white px-4 py-2 rounded-md hover:bg-blue-700 font-semibold text-center">
         + Add Student
      </a>
    <?php endif; ?>
  </div>

  <!-- Desktop Table -->
  <div class="hidden md:block overflow-x-auto">
    <table class="min-w-full border border-gray-200 rounded-lg divide-y divide-gray-200">
      <thead class="bg-collegeblue text-white">
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
      <tbody id="tableBody" class="divide-y divide-gray-200">
        <?php if ($result->num_rows > 0): ?>
          <?php $i=0; while($row = $result->fetch_assoc()): ?>
            <tr class="<?= $i >= 5 ? 'hidden extraRow' : '' ?>">
              <td class="px-4 py-2"><?= htmlspecialchars($row['name']) ?></td>
              <td class="px-4 py-2"><?= htmlspecialchars($row['registration_id'] ?? '-') ?></td>
              <td class="px-4 py-2"><?= htmlspecialchars($row['programme']) ?></td>
              <td class="px-4 py-2"><?= htmlspecialchars($row['batch']) ?></td>
              <td class="px-4 py-2"><?= htmlspecialchars($row['year']) ?></td>
              <td class="px-4 py-2">₹<?= number_format($row['amount'], 2) ?></td>
              <td class="px-4 py-2"><?= htmlspecialchars($row['added_on'] ?? '-') ?></td>
            </tr>
          <?php $i++; endwhile; ?>
        <?php else: ?>
          <tr><td colspan="7" class="text-center py-6 text-gray-500">No students found.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <!-- Mobile Cards -->
  <div class="md:hidden space-y-4">
    <?php
    $result->data_seek(0);
    while($row = $result->fetch_assoc()):
    ?>
      <div class="border rounded-lg shadow p-4">
        <div class="flex justify-between items-center">
          <h3 class="font-semibold text-collegeblue"><?= htmlspecialchars($row['name']) ?></h3>
          <button class="toggleDetails text-collegeblue font-bold text-lg">+</button>
        </div>
        <div class="mt-2 hidden text-sm space-y-1">
          <p><strong>Reg. No:</strong> <?= htmlspecialchars($row['registration_id'] ?? '-') ?></p>
          <p><strong>Programme:</strong> <?= htmlspecialchars($row['programme']) ?></p>
          <p><strong>Batch:</strong> <?= htmlspecialchars($row['batch']) ?></p>
          <p><strong>Year:</strong> <?= htmlspecialchars($row['year']) ?></p>
          <p><strong>Amount:</strong> ₹<?= number_format($row['amount'], 2) ?></p>
          <p><strong>Added On:</strong> <?= htmlspecialchars($row['added_on'] ?? '-') ?></p>
        </div>
      </div>
    <?php endwhile; ?>
  </div>

  <!-- Show More / Less Button for Desktop -->
  <?php if ($result->num_rows > 5): ?>
  <div class="text-center mt-4">
    <button id="toggleTable" class="bg-collegeblue text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
      Show More
    </button>
  </div>
  <?php endif; ?>

  <!-- Year Pagination -->
  <div class="flex justify-center items-center gap-3 mt-10">
    <?php if ($page > 1): ?>
      <a href="?page=<?= $page - 1 ?>" 
         class="px-4 py-2 bg-collegeblue text-white rounded-md hover:bg-blue-700 transition">
         ← Older Year
      </a>
    <?php endif; ?>

    <span class="text-gray-700 font-medium">
      Page <?= $page ?> of <?= $totalYears ?>
    </span>

    <?php if ($page < $totalYears): ?>
      <a href="?page=<?= $page + 1 ?>" 
         class="px-4 py-2 bg-collegeblue text-white rounded-md hover:bg-blue-700 transition">
         Newer Year →
      </a>
    <?php endif; ?>
  </div>

</div>

<script>
// Show more/less for desktop
const toggleBtn = document.getElementById('toggleTable');
if (toggleBtn) {
  const extraRows = document.querySelectorAll('.extraRow');
  let expanded = false;
  toggleBtn.addEventListener('click', () => {
    expanded = !expanded;
    extraRows.forEach(r => r.classList.toggle('hidden', !expanded));
    toggleBtn.textContent = expanded ? 'Show Less' : 'Show More';
  });
}

// Mobile card toggle
document.querySelectorAll('.toggleDetails').forEach(btn => {
  btn.addEventListener('click', () => {
    const details = btn.parentElement.nextElementSibling;
    details.classList.toggle('hidden');
    btn.textContent = details.classList.contains('hidden') ? '+' : '–';
  });
});
</script>

<?php include 'footer.php'; ?>
</body>
</html>
