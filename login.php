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
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body>

<div id="loginModal" class="modal show"> 
    <div class="modal-content">
        <a href="index.php" class="close">&times;</a>
        <h2>User Login</h2>
        <?php if($message != ""): ?>
            <p class="error"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <form method="POST" action="">
            <input type="text" name="registration_id" placeholder="Registration ID" required><br><br>
            <input type="password" name="password" placeholder="Password" required><br><br>
            <button type="submit">Login</button>
        </form>
        <p><a href="reset_password.php">Forgot Password?</a></p>
    </div>
</div>

</body>
</html>
