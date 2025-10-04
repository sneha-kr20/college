<?php
include 'db.php';
include 'navigation.php';
include 'header.php';

$searchTerm = strtolower($_GET['search'] ?? '');
$showAll = isset($_GET['show']) && $_GET['show'] === 'all';

$query = "SELECT * FROM scholarship";
if ($searchTerm !== '') {
    $query .= " WHERE LOWER(name) LIKE '%" . $conn->real_escape_string($searchTerm) . "%'";
}
$query .= " ORDER BY name ASC";
if (!$showAll && $searchTerm === '') {
    $query .= " LIMIT 10";
}

$allStudents = $conn->query($query);
$isPrivileged = isset($_SESSION['role']) && in_array($_SESSION['role'], ['admin', 'professor']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Scholarship Students</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2 style="text-align:center; margin-bottom: 25px;">Scholarship Students</h2>

<!-- Search bar -->
<div class="search-box">
    <form method="GET" action="">
        <input type="text" name="search" placeholder="Search student name..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
        <button type="submit">Search</button>
    </form>
</div>

<!-- Student Table -->
<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Registration No</th>
            <th>Programme</th>
            <th>Batch</th>
            <th>Year</th>
            <th>Amount</th>
            <th>Added On</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($allStudents && $allStudents->num_rows > 0): ?>
            <?php while ($row = $allStudents->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['registration_id'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($row['programme']) ?></td>
                    <td><?= htmlspecialchars($row['batch']) ?></td>
                    <td><?= htmlspecialchars($row['year']) ?></td>
                    <td>₹<?= number_format($row['amount'], 2) ?></td>
                    <td><?= htmlspecialchars($row['added_on'] ?? '-') ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="7" style="text-align:center;">No scholarship students found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php if ($isPrivileged): ?>
    <!-- Add left and Show More/Show Less right -->
    <div class="bottom-buttons">
        <div>
            <a href="scholarship_add.php" class="btn-add">➕ Add Student</a>
        </div>
        <div>
            <?php if (!$showAll && $searchTerm === ''): ?>
                <a href="?show=all" class="btn-add">Show More</a>
            <?php elseif ($showAll): ?>
                <a href="scholarship.php" class="btn-add">Show Less</a>
            <?php endif; ?>
        </div>
    </div>
<?php else: ?>
    <!-- Centered Show More / Show Less for normal users -->
    <div class="center-button">
        <?php if (!$showAll && $searchTerm === ''): ?>
            <a href="?show=all" class="btn-add">Show More</a>
        <?php elseif ($showAll): ?>
            <a href="scholarship.php" class="btn-add">Show Less</a>
        <?php endif; ?>
    </div>
<?php endif; ?>

<?php include 'footer.php'; ?>
</body>
</html>
