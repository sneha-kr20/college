<?php
session_start();
include 'db.php'; 

$message = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reg_id = $_POST['registration_id'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE registration_id='$reg_id' LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if ($user['password'] === $password) { 
            $_SESSION['user'] = $user['registration_id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['name'] = $user['name'];

        //    Redirect to home
            header("Location: index.php");
            exit;
        } else {
            $message = "Wrong password!";
        }
    } else {
        $message = "User not found!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
    <style>
     
.modal {
    display: block; 
    position: fixed; 
    z-index: 1000; 
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto; 
    background-color: rgba(0,0,0,0.5); 
}

.modal-content h2 {
    color: #004080; 
}

.modal-content {
    background-color: #fefefe;
    margin: 15% auto; 
    padding: 20px;
    border-radius: 10px;
    width: 320px; 
    text-align: center;
    position: relative;
    box-shadow: 0 6px 15px rgba(0,0,0,0.2);
}

.modal-content input[type="text"],
.modal-content input[type="password"],
.modal-content input[type="email"] {
    width: 90%;
    padding: 8px;
    margin-bottom: 12px;
    border: 1px solid #ccc;
    border-radius: 6px;
}

.modal-content button {
    background-color: #004080;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 6px;
    cursor: pointer;
    font-weight: bold;
    transition: background 0.3s ease;
}

.modal-content button:hover {
    background-color: #114579;
}

.close {
    position: absolute;
    right: 10px;
    top: 5px;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

.close:hover {
    color: red;
}

p.error {
    color: red;
    margin-bottom: 10px;
}

p.success {
    color: green;
    margin-bottom: 10px;
}

.modal-content a {
    color: #004080;
    text-decoration: underline;
}

.modal-content a:hover {
    color: #0066cc;
}

    </style>
</head>
<body>

<!-- Login Modal -->
<div id="loginModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="window.location='index.php'">&times;</span>
        <h2>User Login</h2>
        <?php if($message != ""): ?>
            <p class="error"><?= $message ?></p>
        <?php endif; ?>

        <form method="POST" action="">
            <input type="text" name="registration_id" placeholder="Registration ID" required><br><br>
            <input type="password" name="password" placeholder="Password" required><br><br>
            <button type="submit">Login</button>
        </form>
        <p><a href="reset_password.php">Forgot Password?</a></p>
    </div>
</div>

</
