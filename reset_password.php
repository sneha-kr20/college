<?php
session_start();
include 'db.php';
$message = "";

// Handle reset request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reg_id = $_POST['registration_id'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        $message = "Passwords do not match!";
    } else {
        $sql = "SELECT * FROM users WHERE registration_id='$reg_id' LIMIT 1";
        $result = $conn->query($sql);
        if ($result->num_rows == 1) {
            $update = "UPDATE users SET password='$new_password' WHERE registration_id='$reg_id'";
            if ($conn->query($update) === TRUE) {
                $message = "Password updated successfully!";
            } else {
                $message = "Error updating password!";
            }
        } else {
            $message = "Registration ID not found!";
        }
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

<!-- Reset Password Modal -->
<div class="modal">
    <div class="modal-content">
        <span class="close" onclick="window.location='index.php'">&times;</span>
        <h2>Reset Password</h2>

        <?php if($message != ""): ?>
            <p class="<?= strpos($message) === 0 ? 'success' : 'error' ?>"><?= $message ?></p>
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
