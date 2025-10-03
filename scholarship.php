<?php
include 'db.php';
include 'navigation.php';
include 'header.php';

$result = $conn->query("SELECT * FROM scholarship ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Scholarship Students</title>
</head>
<p>
  <a href="scholarship_add.php">➕ Add New Scholarship Student</a>
</p>

<body>
  <h2>Scholarship Students</h2>
  <table border="1" cellpadding="8">
    <tr>
      <th>Name</th>
      <th>Programme</th>
      <th>Batch</th>
      <th>Year</th>
      <th>Amount</th>
      <th>Added On</th>
    </tr>
    <?php while($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?= htmlspecialchars($row['name']) ?></td>
        <td><?= htmlspecialchars($row['programme']) ?></td>
        <td><?= htmlspecialchars($row['batch']) ?></td>
        <td><?= $row['year'] ?></td>
        <td><?= $row['amount'] ?></td>
        <td><?= $row['created_at'] ?></td>
      </tr>
    <?php endwhile; ?>
  </table>
</body>
<?php include 'footer.php';?>
</html>
