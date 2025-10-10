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
    $name = trim($_POST['name']);
    $registration_id = trim($_POST['registration_id']);
    $programme = trim($_POST['programme']);
    $batch = trim($_POST['batch']);
    $amountInput = $_POST['amount'] ?? '';
    $amount = filter_var($amountInput, FILTER_VALIDATE_FLOAT);

    // Validation
    if (empty($name) || empty($programme) || empty($batch)) {
        $message = "<p class='text-red-600 font-semibold mb-4'>❌ Name, Programme, and Batch are required.</p>";
    } elseif ($amount === false || $amount <= 0) {
        $message = "<p class='text-red-600 font-semibold mb-4'>❌ Amount must be positive.</p>";
    } else {
        // Insert using prepared statement
        $stmt = $conn->prepare("
            INSERT INTO scholarship (name, registration_id, programme, batch, amount, created_at)
            VALUES (?, ?, ?, ?, ?, NOW())
        ");
        $stmt->bind_param("ssssd", $name, $registration_id, $programme, $batch, $amount);

        if ($stmt->execute()) {
            $message = "<p class='text-green-600 font-semibold mb-4 animate-fade-in'>✔ Student added successfully!</p>";
            $_POST = []; // Clear form
        } else {
            $message = "<p class='text-red-600 font-semibold mb-4 animate-fade-in'>❌ Error: " . htmlspecialchars($stmt->error) . "</p>";
        }
        $stmt->close();
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

<main class="page-container py-20">
    <div class="max-w-lg mx-auto bg-white rounded-3xl shadow-lg p-8 glass-card animate-fade-in relative">

        <h1 class="page-heading page-heading-glow text-center mb-6">
            Add Scholarship Student
        </h1>

        <?= $message ?>

        <form method="POST" class="flex flex-col gap-4 animate-fade-in">
            <input type="text" name="name" placeholder="Full Name" required
                   value="<?= htmlspecialchars($_POST['name'] ?? '') ?>"
                   class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-collegeblue">
            
            <input type="text" name="registration_id" placeholder="Registration Number"
                   value="<?= htmlspecialchars($_POST['registration_id'] ?? '') ?>"
                   class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-collegeblue">

            <input type="text" name="programme" placeholder="Programme" required
                   value="<?= htmlspecialchars($_POST['programme'] ?? '') ?>"
                   class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-collegeblue">

            <input type="text" name="batch" placeholder="Batch" required
                   value="<?= htmlspecialchars($_POST['batch'] ?? '') ?>"
                   class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-collegeblue">

            <input type="number" step="0.01" name="amount" placeholder="Amount (₹)" required
                   value="<?= htmlspecialchars($_POST['amount'] ?? '') ?>"
                   class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-collegeblue">

            <button type="submit" class="btn-primary w-full text-center">
                Add Student
            </button>
        </form>

        <a href="scholarship.php" 
           class="mt-6 inline-block w-full text-center text-collegeblue font-semibold hover:underline">
           ← Back to Scholarship List
        </a>

    </div>
</main>

</body>
</html>
