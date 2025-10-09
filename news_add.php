<?php
session_start();
include 'db.php';

$message = "";

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
  <title>Add News / Notice</title>
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

<div class="bg-white rounded-xl shadow-lg w-full max-w-md p-8 relative">
    <!-- Close button -->
    <a href="news.php" class="absolute top-4 right-4 text-2xl text-gray-600 font-bold hover:text-red-500">&times;</a>

    <h2 class="text-2xl font-bold text-collegeblue mb-6 text-center">Add New Notice</h2>

    <!-- Message -->
    <?= $message ?>

    <form method="POST" enctype="multipart/form-data" class="flex flex-col gap-4">
        <input type="text" name="title" placeholder="Title" required
               class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-collegeblue">

        <textarea name="content" rows="5" placeholder="Notice Content" required
                  class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-collegeblue"></textarea>

        <input type="file" name="file"
               class="w-full p-2 border border-gray-300 rounded-md">

        <button type="submit"
                class="bg-collegeblue text-white font-semibold py-3 rounded-md hover:bg-blue-700 transition-colors">
            Post Notice
        </button>
    </form>

    <a href="news.php" class="mt-4 inline-block text-collegeblue font-semibold hover:underline text-center w-full">
        Back to Notice Board
    </a>
</div>

</body>
</html>
