<?php
session_start();
include 'db.php';
include 'tailwind.php';
include 'components.php'; 

// Only allow admins or professors
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['admin', 'professor'])) {
    echo "<p class='text-red-600 font-semibold'>❌ You do not have permission to add scholarship students.</p>";
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
        $message = "<p class='text-green-600 font-semibold mb-4 animate-fade-in'>✔ Student added successfully!</p>";
    } else {
        $message = "<p class='text-red-600 font-semibold mb-4 animate-fade-in'>❌ Error: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Scholarship Student - Jehal Prasad TTC</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class="min-h-screen font-sans text-gray-900">

<?php
$current_page = basename($_SERVER['PHP_SELF']);
$add_link = 'scholarship_add.php';
?>

<main class="page-container py-20">
    <div class="max-w-lg mx-auto bg-white rounded-3xl shadow-lg p-8 glass-card animate-fade-in relative">

        <!-- Heading with universal animation -->
        <h1 class="page-heading page-heading-glow text-center mb-6">
            Add Scholarship Student
        </h1>

        <!-- Message -->
        <?= $message ?>

        <!-- Form -->
        <form method="POST" class="flex flex-col gap-4 animate-fade-in">
            <input type="text" name="name" placeholder="Name" required
                   class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-collegeblue">
            <input type="text" name="programme" placeholder="Programme" required
                   class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-collegeblue">
            <input type="text" name="batch" placeholder="Batch" required
                   class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-collegeblue">
            <input type="number" name="year" placeholder="Year" required
                   class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-collegeblue">
            <input type="number" step="0.01" name="amount" placeholder="Amount" required
                   class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-collegeblue">

            <button type="submit" class="btn-primary w-full text-center">
                Add Student
            </button>
        </form>

        <!-- Back Button -->
        <a href="scholarship.php" 
           class="mt-6 inline-block w-full text-center text-collegeblue font-semibold hover:underline">
           ← Back to Scholarship List
        </a>

    </div>
</main>

</body>
</html>
