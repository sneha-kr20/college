<?php
$host = "localhost";   // XAMPP always uses localhost
$user = "root";        // default username in XAMPP
$pass = "";            // default password is empty
$db   = "college";     // your database name

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
