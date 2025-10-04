<?php
session_start();
include 'db.php';
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
<html>
<head>
    <title>Reset Password - Jehal Prasad TTC</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="modal show"> 
    <div class="modal-content">
        <a href="index.php" class="close">&times;</a>
        <h2>Reset Password</h2>

        <?php if($message != ""): ?>
            <p class="<?= $status ?>"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <form method="POST" action="">
            <input type="text" name="registration_id" placeholder="Registration ID" required><br><br>
            <input type="password" name="new_password" placeholder="New Password" required><br><br>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required><br><br>
            <button type="submit">Reset Password</button>
        </form>

        <p><a href="login.php">Back to Login</a></p>
    </div>
</div>

</body>
</html>
