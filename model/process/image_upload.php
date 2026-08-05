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
    
    // If they intentionally left the image blank, just skip and return blank
    if ($file['error'] === UPLOAD_ERR_NO_FILE) {
        return $existingImagePath;
    }

    // IF AN UPLOAD HAPPENED BUT FAILED, YELL EXACTLY WHY
    if ($file['error'] !== UPLOAD_ERR_OK) {
        $phpErrors = [
            1 => 'The image is too large! It exceeds the upload_max_filesize in php.ini (Usually 2MB).',
            2 => 'The image exceeds the HTML form file limit.',
            3 => 'The image was only partially uploaded.',
            6 => 'Missing a temporary folder on the server.',
            7 => 'Failed to write image to disk.',
        ];
        $errMsg = $phpErrors[$file['error']] ?? 'Unknown PHP upload error.';
        throw new Exception($errMsg);
    }

    $imageInfo = @getimagesize($file['tmp_name']);
    if ($imageInfo === false) {
        throw new Exception("File is not a valid image format.");
    }

    $allowedTypes = [
        IMAGETYPE_JPEG => 'jpg',
        IMAGETYPE_PNG => 'png',
        IMAGETYPE_GIF => 'gif',
        IMAGETYPE_WEBP => 'webp'
    ];

    if (!isset($allowedTypes[$imageInfo[2]])) {
        throw new Exception("Unsupported image type. Please use JPG, PNG, GIF, or WEBP.");
    }

    if (!ensureUploadDirectoryExists($uploadDir)) {
        throw new Exception("Failed to create the thumbnails upload folder.");
    }

    $extension = $allowedTypes[$imageInfo[2]];
    $filename = generateUploadFilename($file['name'], $extension);
    
    // FIX: Safely trims both forward and backward slashes to prevent Windows/Mac pathing bugs
    $destination = rtrim($uploadDir, '/\\') . '/' . $filename;

    if (!move_uploaded_file($file['tmp_name'], $destination)) {
        throw new Exception("Failed to physically move the image into the thumbnails folder.");
    }

    // Delete old image if updating
    if (!empty($existingImagePath) && str_starts_with($existingImagePath, $webPathPrefix . '/')) {
        $previousPath = rtrim($uploadDir, '/\\') . '/' . basename($existingImagePath);
        if (is_file($previousPath)) {
            @unlink($previousPath);
        }
    }

    return $webPathPrefix . '/' . $filename;
}
