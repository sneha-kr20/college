<?php
session_start();
include 'db.php';
include 'tailwind.php';

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
        $message = "<p class='text-green-600 font-semibold mb-4'>✔ Student added successfully!</p>";
    } else {
        $message = "<p class='text-red-600 font-semibold mb-4'>❌ Error: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Scholarship Student</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>
<body class="bg-gray-50 font-sans flex items-center justify-center min-h-screen p-4">

<div class="bg-white rounded-xl shadow-lg w-full max-w-md p-8 relative">
    <!-- Close button -->
    <span class="absolute top-4 right-4 text-2xl text-gray-600 font-bold cursor-pointer hover:text-red-500"
          onclick="window.location='scholarship.php'">&times;</span>

    <h2 class="text-2xl font-bold text-collegeblue mb-6 text-center">Add Scholarship Student</h2>

    <!-- Message -->
    <?= $message ?>

    <form method="POST" class="flex flex-col gap-4">
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

        <button type="submit"
                class="bg-collegeblue text-white font-semibold py-3 rounded-md hover:bg-blue-700 transition-colors">
            Add Student
        </button>
    </form>

    <a href="scholarship.php"
       class="mt-4 inline-block text-collegeblue font-semibold hover:underline text-center w-full">
        Back to Scholarship List
    </a>
</div>

</body>
</html>
