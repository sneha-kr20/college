
<?php
include 'db.php';
include 'navigation.php';
include 'header.php';

// If form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $programme = $_POST['programme'];
    $batch = $_POST['batch'];
    $year = $_POST['year'];
    $amount = $_POST['amount'];

    // Insert into DB
    $sql = "INSERT INTO scholarship (name, programme, batch, year, amount)
            VALUES ('$name', '$programme', '$batch', '$year', '$amount')";

    if ($conn->query($sql) === TRUE) {
        echo "<p style='color:green;'>✔ Student added successfully!</p>";
    } else {
        echo "<p style='color:red;'>Error: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add Scholarship Student</title>
</head>
<body>
  <h2>Add Scholarship Student</h2>
  <form method="POST">
    <label>Name:</label> <input type="text" name="name" required><br><br>
    <label>Programme:</label> <input type="text" name="programme" required><br><br>
    <label>Batch:</label> <input type="text" name="batch" required><br><br>
    <label>Year:</label> <input type="number" name="year" required><br><br>
    <label>Amount:</label> <input type="number" step="0.01" name="amount" required><br><br>
    <button type="submit">Add Student</button>
  </form>
</body>
<p>
  <a href="scholarship.php">⬅ Back to Student List</a>
</p>
<?php include 'footer.php';?>

</html>
