<?php
session_start();
include 'db.php';
include 'tailwind.php';

$message = "";
$status = "error"; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reg_id = trim($_POST['registration_id']);
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        $message = "Passwords do not match!";
    } else {
        $stmt = $conn->prepare("SELECT id FROM users WHERE registration_id = ? LIMIT 1");
        $stmt->bind_param("s", $reg_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            $update = $conn->prepare("UPDATE users SET password = ? WHERE registration_id = ?");
            $update->bind_param("ss", $hashed_password, $reg_id);

            if ($update->execute()) {
                $message = "Password updated successfully!";
                $status = "success";
            } else {
                $message = "Error updating password!";
            }
            $update->close();
        } else {
            $message = "Registration ID not found!";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password - Jehal Prasad TTC</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class="min-h-screen font-sans text-gray-900">

<main class="page-container py-20">
    <div class="max-w-sm mx-auto bg-white rounded-3xl shadow-lg p-8 glass-card animate-fade-in relative">

        <!-- Close Button -->
        <a href="index.php" class="absolute top-4 right-4 text-2xl text-gray-600 font-bold hover:text-red-500 transition-transform duration-300 hover:scale-110">&times;</a>

        <!-- Heading -->
        <h1 class="page-heading page-heading-glow text-center mb-6">
            Reset Password
        </h1>

        <!-- Message -->
        <?php if($message != ""): ?>
            <p class="<?= $status === 'success' ? 'text-green-600' : 'text-red-600' ?> font-semibold mb-4 animate-fade-in">
                <?= htmlspecialchars($message) ?>
            </p>
        <?php endif; ?>

        <!-- Form -->
        <form method="POST" action="" class="flex flex-col gap-4 animate-fade-in">
            <input type="text" name="registration_id" placeholder="Registration ID" required
                   class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-collegeblue">
            <input type="password" name="new_password" placeholder="New Password" required
                   class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-collegeblue">
            <input type="password" name="confirm_password" placeholder="Confirm Password" required
                   class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-collegeblue">

            <button type="submit" class="btn-primary w-full text-center">
                Reset Password
            </button>
        </form>

        <!-- Back to login -->
        <p class="mt-4 text-center">
            <a href="login.php" class="text-collegeblue hover:underline font-semibold">
                Back to Login
            </a>
        </p>
    </div>
</main>

</body>
</html>
