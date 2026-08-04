<?php

function ensureUploadDirectoryExists(string $uploadDir): bool {
    if (is_dir($uploadDir)) {
        return true;
    }

    return mkdir($uploadDir, 0755, true);
}

function generateUploadFilename(string $originalName, string $extension): string {
    $baseName = pathinfo($originalName, PATHINFO_FILENAME);
    $baseName = preg_replace('/[^A-Za-z0-9_-]/', '_', $baseName);
    $baseName = substr($baseName, 0, 50);

    return sprintf('%s_%s.%s', $baseName ?: 'spot_image', bin2hex(random_bytes(6)), $extension);
}

function handleSpotImageUpload(string $fileInputName, string $uploadDir, string $webPathPrefix, string $existingImagePath = ''): string {
    if (!isset($_FILES[$fileInputName])) {
        return $existingImagePath;
    }

    $file = $_FILES[$fileInputName];
    if ($file['error'] === UPLOAD_ERR_NO_FILE) {
        return $existingImagePath;
    }

    if ($file['error'] !== UPLOAD_ERR_OK) {
        return $existingImagePath;
    }

    $imageInfo = @getimagesize($file['tmp_name']);
    if ($imageInfo === false) {
        return $existingImagePath;
    }

    $allowedTypes = [
        IMAGETYPE_JPEG => 'jpg',
        IMAGETYPE_PNG => 'png',
        IMAGETYPE_GIF => 'gif',
        IMAGETYPE_WEBP => 'webp'
    ];

    if (!isset($allowedTypes[$imageInfo[2]])) {
        return $existingImagePath;
    }

    if (!ensureUploadDirectoryExists($uploadDir)) {
        return $existingImagePath;
    }

    $extension = $allowedTypes[$imageInfo[2]];
    $filename = generateUploadFilename($file['name'], $extension);
    $destination = rtrim($uploadDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $filename;

    if (!move_uploaded_file($file['tmp_name'], $destination)) {
        return $existingImagePath;
    }

    if (!empty($existingImagePath) && str_starts_with($existingImagePath, $webPathPrefix . '/')) {
        $previousPath = rtrim($uploadDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . basename($existingImagePath);
        if (is_file($previousPath)) {
            @unlink($previousPath);
        }
    }

    return $webPathPrefix . '/' . $filename;
}
