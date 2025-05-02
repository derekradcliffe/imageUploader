<?php
class ImageUploader
{
    private $uploadDir;
    private $maxFileSize;
    private $allowedTypes;

    public function __construct()
    {
        $this->uploadDir = UPLOAD_DIR;
        $this->maxFileSize = MAX_FILE_SIZE;
        $this->allowedTypes = ALLOWED_TYPES;
        $this->createUploadDirectory();
    }

    private function createUploadDirectory()
    {
        if (!file_exists($this->uploadDir)) {
            mkdir($this->uploadDir, 0777, true);
        }
    }

    public function handleUpload($file)
    {
        if (!isset($file) || $file['error'] === UPLOAD_ERR_NO_FILE) {
            return ['success' => false, 'message' => 'No file was uploaded.'];
        }

        $imageFileType = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!$this->isImage($file['tmp_name'])) {
            return ['success' => false, 'message' => 'File is not an image.'];
        }

        if ($file['size'] > $this->maxFileSize) {
            return ['success' => false, 'message' => "Sorry, your file is too large. File size: " . round($file['size'] / 1000000, 2) . " MB. Maximum allowed: " . ($this->maxFileSize / 1000000) . " MB"];
        }

        if (!in_array($imageFileType, $this->allowedTypes)) {
            return ['success' => false, 'message' => 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.'];
        }

        $targetFile = $this->uploadDir . basename($file['name']);

        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            return ['success' => true, 'message' => "The file {$file['name']} has been uploaded."];
        }

        return ['success' => false, 'message' => 'Sorry, there was an error uploading your file.'];
    }

    private function isImage($filePath)
    {
        $check = getimagesize($filePath);
        return $check !== false;
    }
}
