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
<body class="bg-gray-50 font-sans flex items-center justify-center min-h-screen p-4">

<div class="bg-white rounded-xl shadow-lg w-full max-w-sm p-8 relative">
    <!-- Close button -->
    <a href="index.php" class="absolute top-4 right-4 text-2xl text-gray-600 font-bold hover:text-red-500">&times;</a>

    <h2 class="text-2xl font-bold text-collegeblue mb-6 text-center">Reset Password</h2>

    <!-- Message -->
    <?php if($message != ""): ?>
        <p class="<?= $status === 'success' ? 'text-green-600' : 'text-red-600' ?> font-semibold mb-4">
            <?= htmlspecialchars($message) ?>
        </p>
    <?php endif; ?>

    <form method="POST" action="" class="flex flex-col gap-4">
        <input type="text" name="registration_id" placeholder="Registration ID" required
               class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-collegeblue">

        <input type="password" name="new_password" placeholder="New Password" required
               class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-collegeblue">

        <input type="password" name="confirm_password" placeholder="Confirm Password" required
               class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-collegeblue">

        <button type="submit"
                class="bg-collegeblue text-white font-semibold py-3 rounded-md hover:bg-blue-700 transition-colors">
            Reset Password
        </button>
    </form>

    <p class="mt-4 text-center">
        <a href="login.php" class="text-collegeblue hover:underline font-semibold">
            Back to Login
        </a>
    </p>
</div>

</body>
</html>
