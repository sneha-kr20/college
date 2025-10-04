<?php
session_start();
include 'db.php';

// Only allow admins or professors
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['admin', 'professor'])) {
    echo "<p style='color:red;'>❌ You do not have permission to add scholarship students.</p>";
    exit;
}

$message = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $programme = $conn->real_escape_string($_POST['programme']);
    $batch = $conn->real_escape_string($_POST['batch']);
    $year = (int)$_POST['year'];
    $amount = (float)$_POST['amount'];

    $sql = "INSERT INTO scholarship (name, programme, batch, year, amount, added_on)
            VALUES ('$name', '$programme', '$batch', $year, $amount, NOW())";

    if ($conn->query($sql) === TRUE) {
        $message = "<p class='success'>✔ Student added successfully!</p>";
    } else {
        $message = "<p class='error'>❌ Error: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Scholarship Student</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- Scholarship Add Modal -->
<div class="modal show">
  <div class="modal-content">
    <span class="close" onclick="window.location='scholarship.php'">&times;</span>
    <h2>Add Scholarship Student</h2>

    <?= $message ?>

    <form method="POST" class="scholarship-form">
        <input type="text" name="name" placeholder="Name" required>
        <input type="text" name="programme" placeholder="Programme" required>
        <input type="text" name="batch" placeholder="Batch" required>
        <input type="number" name="year" placeholder="Year" required>
        <input type="number" step="0.01" name="amount" placeholder="Amount" required>

        <button type="submit">Add Student</button>
    </form>

    <a href="scholarship.php" class="back-link"> Back to Scholarship List</a>
  </div>
</div>

</body>
</html>
