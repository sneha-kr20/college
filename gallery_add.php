<?php
session_start();
include 'db.php';
include 'tailwind.php';
include 'components.php'; 
$message = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $caption = trim($_POST['caption']);

    $targetDir = "uploads/";
    $fileName = basename($_FILES["image"]["name"]);
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowedTypes = ["jpg", "jpeg", "png", "gif", "webp"];

    if (in_array($fileExt, $allowedTypes)) {
        $newFileName = uniqid("img_", true) . "." . $fileExt;
        $targetFilePath = $targetDir . $newFileName;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
            
            // Generate thumbnail
            $thumbFileName = uniqid("thumb_", true) . "." . $fileExt;
            $thumbFilePath = $targetDir . $thumbFileName;
            list($width, $height) = getimagesize($targetFilePath);
            $newWidth = 300;
            $newHeight = floor($height * ($newWidth / $width));
            $thumb = imagecreatetruecolor($newWidth, $newHeight);

            switch($fileExt) {
                case 'jpg': case 'jpeg': $source = imagecreatefromjpeg($targetFilePath); break;
                case 'png': $source = imagecreatefrompng($targetFilePath); break;
                case 'gif': $source = imagecreatefromgif($targetFilePath); break;
                case 'webp': $source = imagecreatefromwebp($targetFilePath); break;
            }

            imagecopyresampled($thumb, $source, 0,0,0,0, $newWidth,$newHeight, $width,$height);

            switch($fileExt) {
                case 'jpg': case 'jpeg': imagejpeg($thumb, $thumbFilePath, 85); break;
                case 'png': imagepng($thumb, $thumbFilePath); break;
                case 'gif': imagegif($thumb, $thumbFilePath); break;
                case 'webp': imagewebp($thumb, $thumbFilePath, 85); break;
            }

            imagedestroy($thumb);
            imagedestroy($source);

            // Insert into DB
            $stmt = $conn->prepare("INSERT INTO gallery (image_path, thumbnail_path, caption) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $targetFilePath, $thumbFilePath, $caption);
            $stmt->execute();
            $stmt->close();

            $message = "<p class='text-green-600 font-semibold mb-4 animate-fade-in'>✔ Image uploaded successfully!</p>";
        } else {
            $message = "<p class='text-red-600 font-semibold mb-4 animate-fade-in'>❌ File upload failed.</p>";
        }
    } else {
        $message = "<p class='text-red-600 font-semibold mb-4 animate-fade-in'>⚠ Only JPG, JPEG, PNG, GIF, and WEBP files are allowed.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Gallery Image - Jehal Prasad TTC</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class="min-h-screen font-sans text-gray-900">

<?php
$current_page = basename($_SERVER['PHP_SELF']);
$add_link = 'gallery_add.php';
?>

<main class="page-container py-20">
    <div class="max-w-lg mx-auto bg-white rounded-3xl shadow-lg p-8 glass-card animate-fade-in relative">
        <h1 class="page-heading page-heading-glow text-center mb-6">
            Add New Image
        </h1>

        <!-- Message -->
        <?= $message ?>

        <!-- Form -->
        <form method="POST" enctype="multipart/form-data" class="flex flex-col gap-4 animate-fade-in">
            <input type="text" name="caption" placeholder="Caption" required
                   class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-collegeblue hover:shadow-md transition-shadow duration-300">
            <input type="file" name="image" accept="image/*" required
                   class="w-full p-2 border border-gray-300 rounded-md hover:shadow-md transition-shadow duration-300">
            <button type="submit" 
                    class="btn-primary w-full text-center">
                Upload
            </button>
        </form>

        <!-- Back Button -->
        <a href="gallery.php" 
           class="mt-6 inline-block w-full text-center text-collegeblue font-semibold hover:underline">
           ← Back to Gallery
        </a>
    </div>
</main>

</body>
</html>
