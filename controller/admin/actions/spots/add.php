<?php
require_once "../../../../view/admin/includes/db.php";
require_once "../../../../model/process/spotmodel.php";
require_once "../../../../model/process/image_upload.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../../../../view/admin/spots.php");
    exit();
}

$name = trim($_POST["name"] ?? "");
$location = trim($_POST["location"] ?? "");
$description = trim($_POST["description"] ?? "");
$image = trim($_POST["image"] ?? "");
$hours = trim($_POST["hours"] ?? "");
$noise = $_POST["noise"] ?? "Low";
$privacy = $_POST["privacy"] ?? "Low";
$price = $_POST["price"] ?? "Free";
$rawTagIds = $_POST["tag_ids"] ?? [];

$uploadDir = dirname(__DIR__, 4) . '/view/uploads';
$image = handleSpotImageUpload('image', $uploadDir, 'uploads', '');

if (empty($name) || empty($location)) {
    header("Location: ../../../../view/admin/spots.php");
    exit();
}

addSpot($conn, $name, $location, $description, $image, $hours, $noise, $privacy, $price, $rawTagIds);
/*
mysqli_begin_transaction($conn);

try {
    $stmt = mysqli_prepare($conn, "INSERT INTO spots (name, location, description, image, hours, noise, privacy, price) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssssssss", $name, $location, $description, $image, $hours, $noise, $privacy, $price);
    mysqli_stmt_execute($stmt);

    $spotId = mysqli_insert_id($conn);
    $tagIds = [];

    if (isset($_POST["tag_ids"]) && is_array($_POST["tag_ids"])) {
        foreach ($_POST["tag_ids"] as $tagId) {
            $tagId = filter_var($tagId, FILTER_VALIDATE_INT);
            if ($tagId) {
                $tagIds[] = $tagId;
            }
        }
    }

    $tagIds = array_values(array_unique($tagIds));

    foreach ($tagIds as $tagId) {
        $tagCheck = mysqli_prepare($conn, "SELECT id FROM tags WHERE id = ?");
        mysqli_stmt_bind_param($tagCheck, "i", $tagId);
        mysqli_stmt_execute($tagCheck);
        $tagResult = mysqli_stmt_get_result($tagCheck);

        if (mysqli_num_rows($tagResult) > 0) {
            $tagLinkStmt = mysqli_prepare($conn, "INSERT IGNORE INTO spot_tags (spot_id, tag_id) VALUES (?, ?)");
            mysqli_stmt_bind_param($tagLinkStmt, "ii", $spotId, $tagId);
            mysqli_stmt_execute($tagLinkStmt);
        }
    }

    mysqli_commit($conn);
} catch (Exception $e) {
    mysqli_rollback($conn);
    throw $e;
}
*/

header("Location: ../../../../view/admin/spots.php?status=created");
exit();
