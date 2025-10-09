<?php
session_start();
include 'db.php'; 
include 'navigation.php';
include 'tailwind.php';

$message = "";

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
            
            // ===== Generate thumbnail =====
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

            // ===== Insert into DB =====
            $stmt = $conn->prepare("INSERT INTO gallery (image_path, thumbnail_path, caption) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $targetFilePath, $thumbFilePath, $caption);
            $stmt->execute();
            $stmt->close();

            $message = "<p class='text-green-600 font-semibold mb-4'>✔ Image uploaded successfully!</p>";
        } else {
            $message = "<p class='text-red-600 font-semibold mb-4'>File upload failed.</p>";
        }
    } else {
        $message = "<p class='text-red-600 font-semibold mb-4'>⚠ Only JPG, JPEG, PNG, GIF, and WEBP files are allowed.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Gallery Image</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
</head>
<body class="bg-gray-50 font-sans flex items-center justify-center min-h-screen p-4">

<div class="bg-white rounded-xl shadow-lg w-full max-w-md p-8 relative">
    <a href="gallery.php" class="absolute top-4 right-4 text-2xl text-gray-600 font-bold hover:text-red-500">&times;</a>
    <h2 class="text-2xl font-bold text-collegeblue mb-6 text-center">Add New Image</h2>

    <?= $message ?>

    <form method="POST" enctype="multipart/form-data" class="flex flex-col gap-4">
        <input type="text" name="caption" placeholder="Caption" required
               class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-collegeblue">
        <input type="file" name="image" accept="image/*" required
               class="w-full p-2 border border-gray-300 rounded-md">
        <button type="submit" 
                class="bg-collegeblue text-white font-semibold py-3 rounded-md hover:bg-blue-700 transition-colors">
            Upload
        </button>
    </form>

    <a href="gallery.php" class="mt-4 inline-block text-collegeblue font-semibold hover:underline text-center w-full">
        Back to Gallery
    </a>
</div>

</body>
</html>
