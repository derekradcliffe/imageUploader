<?php
session_start();
require_once 'config.php';
require_once 'classes/ImageUploader.php';

$message = isset($_SESSION['message']) ? $_SESSION['message'] : "";
$_SESSION['message'] = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $uploader = new ImageUploader();
    $result = $uploader->handleUpload($_FILES["fileToUpload"]);
    $_SESSION['message'] = $result['message'];
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/styles.css">
    <title>Image Upload</title>
</head>

<body>
    <div class="container">
        <div class="title">Upload an Image</div>

        <div class="file-uploaded-message">
            <?php if (!empty($message)): ?>
                <p class="<?php echo strpos($message, 'has been uploaded') !== false ? 'success' : 'error'; ?>">
                    <?php echo htmlspecialchars($message, ENT_QUOTES); ?>
                </p>
            <?php endif; ?>
        </div>

        <p><b>File must be in JPG, JPEG, PNG, or GIF format and less than 5MB in size.</b></p>

        <form action="" method="post" enctype="multipart/form-data">
            <div class="cta-wrapper">
                <label for="fileToUpload" class="custom-file-upload">Choose Image</label>
                <input type="file" name="fileToUpload" id="fileToUpload" style="display: none;" accept="image/*">
                <span class="file-name-display">No file chosen</span>
                <input type="submit" value="Upload Image" name="submit">
            </div>
        </form>
    </div>

    <script src="assets/js/upload.js"></script>
</body>

</html>
