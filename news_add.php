<?php
session_start();
include 'db.php';
include 'tailwind.php';
include 'components.php'; // contains add_button()
$message = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $file_path = NULL;

    if (isset($_FILES["file"]) && $_FILES["file"]["size"] > 0) {
        $targetDir = "uploads/";
        $fileName = basename($_FILES["file"]["name"]);
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedTypes = ["pdf", "doc", "docx", "jpg", "jpeg", "png", "gif", "webp"];

        if (in_array($fileExt, $allowedTypes)) {
            $newFileName = uniqid("file_", true) . "." . $fileExt;
            $targetFilePath = $targetDir . $newFileName;

            if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
                $file_path = $targetFilePath;
            } else {
                $message = "<p class='text-red-600 font-semibold mb-4'>❌ File upload failed.</p>";
            }
        } else {
            $message = "<p class='text-red-600 font-semibold mb-4'>⚠ Only PDF, DOC, DOCX, JPG, JPEG, PNG, GIF, WEBP are allowed.</p>";
        }
    }

    if ($message === "") {
        $stmt = $conn->prepare("INSERT INTO news (title, content, file_path) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $title, $content, $file_path);

        if ($stmt->execute()) {
            $message = "<p class='text-green-600 font-semibold mb-4'>✔ Notice added successfully!</p>";
        } else {
            $message = "<p class='text-red-600 font-semibold mb-4'>Database error: " . $conn->error . "</p>";
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Notice - Jehal Prasad TTC</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class="min-h-screen font-sans text-gray-900">

<?php
$current_page = basename($_SERVER['PHP_SELF']);
$add_link = 'news_add.php';
?>

<main class="page-container py-20">
    <div class="max-w-lg mx-auto bg-white rounded-3xl shadow-lg p-8 glass-card animate-fade-in relative">

        <!-- Heading with universal animation -->
        <h1 class="page-heading page-heading-glow text-center mb-6">
            Add New Notice
        </h1>

        <!-- Message -->
        <?= $message ?>

        <!-- Form -->
        <form method="POST" enctype="multipart/form-data" class="flex flex-col gap-4">
            <input type="text" name="title" placeholder="Title" required
                class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-collegeblue">

            <textarea name="content" rows="5" placeholder="Notice Content" required
                class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-collegeblue"></textarea>

            <input type="file" name="file"
                class="w-full p-2 border border-gray-300 rounded-md">

            <button type="submit"
                class="btn-primary w-full text-center">
                Post Notice
            </button>
        </form>

        <!-- Back Button -->
        <a href="news.php" 
           class="mt-6 inline-block w-full text-center text-collegeblue font-semibold hover:underline">
           ← Back to Notice Board
        </a>

    </div>
</main>
</body>
</html>
