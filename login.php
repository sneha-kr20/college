<?php
session_start();
include 'db.php';
include 'components.php'; 
$message = "";

// Handle login
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $reg_id = trim($_POST['registration_id']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, registration_id, password, name, role FROM users WHERE registration_id = ? LIMIT 1");
    $stmt->bind_param("s", $reg_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user['registration_id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['name'] = $user['name'];

            header("Location: index.php");
            exit(); 
        } else {
            $message = "Wrong password!";
        }
    } else {
        $message = "User not found!";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Jehal Prasad TTC</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'tailwind.php'; ?>
</head>
<body class="min-h-screen flex items-center justify-center">

<div class="max-w-sm w-full bg-white rounded-3xl shadow-lg p-8 glass-card animate-fade-in">
    <h1 class="page-heading page-heading-glow mb-6 text-center">Login</h1>

    <?php if($message): ?>
        <p class="text-red-600 font-semibold mb-4 animate-fade-in"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form method="POST" action="" class="flex flex-col gap-4">
        <input type="text" name="registration_id" placeholder="Registration ID" required
               class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-collegeblue">
        <input type="password" name="password" placeholder="Password" required
               class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-collegeblue">
        <button type="submit" class="btn-primary w-full text-center">Login</button>
    </form>

    <p class="mt-4 text-center">
        <a href="reset_password.php" class="text-collegeblue hover:underline font-semibold">Forgot Password?</a>
    </p>
</div>

</body>
</html>
