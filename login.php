<?php
session_start();
include 'db.php'; 

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reg_id = trim($_POST['registration_id']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE registration_id = ? LIMIT 1");
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
            exit;
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
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = {
        theme: {
          extend: {
            colors: {
              collegeblue: '#004080'
            },
            fontFamily: {
              sans: ['Segoe UI', 'Tahoma', 'Geneva', 'Verdana', 'sans-serif']
            }
          }
        }
      }
    </script>
</head>
<body class="bg-gray-50 font-sans flex items-center justify-center min-h-screen p-4">

<div class="bg-white rounded-xl shadow-lg w-full max-w-sm p-8 relative">
    <!-- Close button -->
    <a href="index.php" class="absolute top-4 right-4 text-2xl text-gray-600 font-bold hover:text-red-500">&times;</a>

    <h2 class="text-2xl font-bold text-collegeblue mb-6 text-center">User Login</h2>

    <!-- Message -->
    <?php if($message != ""): ?>
        <p class="text-red-600 font-semibold mb-4"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form method="POST" action="" class="flex flex-col gap-4">
        <input type="text" name="registration_id" placeholder="Registration ID" required
               class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-collegeblue">

        <input type="password" name="password" placeholder="Password" required
               class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-collegeblue">

        <button type="submit"
                class="bg-collegeblue text-white font-semibold py-3 rounded-md hover:bg-blue-700 transition-colors">
            Login
        </button>
    </form>

    <p class="mt-4 text-center">
        <a href="reset_password.php" class="text-collegeblue hover:underline font-semibold">
            Forgot Password?
        </a>
    </p>
</div>

</body>
</html>
