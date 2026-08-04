<?php
require_once "../../../../view/admin/includes/db.php";
require_once "../../../../model/process/spotmodel.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../../../../view/admin/spots.php");
    exit();
}

$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
$name = trim($_POST["name"] ?? "");
$location = trim($_POST["location"] ?? "");
$description = trim($_POST["description"] ?? "");
$image = trim($_POST["image"] ?? "");
$hours = trim($_POST["hours"] ?? "");
$noise = $_POST["noise"] ?? "Low";
$privacy = $_POST["privacy"] ?? "Low";
$price = $_POST["price"] ?? "Free";
$rawTagIds = $_POST["tag_ids"] ?? [];

if (!$id || empty($name) || empty($location)) {
    header("Location: ../../../../view/admin/spots.php");
    exit();
}

editSpot($conn, $id, $name, $location, $description, $image, $hours, $noise, $privacy, $price, $rawTagIds);
/*
mysqli_begin_transaction($conn);

try {
    $stmt = mysqli_prepare($conn, "UPDATE spots SET name = ?, location = ?, description = ?, image = ?, hours = ?, noise = ?, privacy = ?, price = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "ssssssssi", $name, $location, $description, $image, $hours, $noise, $privacy, $price, $id);
    mysqli_stmt_execute($stmt);

    $clearTagsStmt = mysqli_prepare($conn, "DELETE FROM spot_tags WHERE spot_id = ?");
    mysqli_stmt_bind_param($clearTagsStmt, "i", $id);
    mysqli_stmt_execute($clearTagsStmt);

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
            $tagLinkStmt = mysqli_prepare($conn, "INSERT INTO spot_tags (spot_id, tag_id) VALUES (?, ?)");
            mysqli_stmt_bind_param($tagLinkStmt, "ii", $id, $tagId);
            mysqli_stmt_execute($tagLinkStmt);
        }
    }

    mysqli_commit($conn);
} catch (Exception $e) {
    mysqli_rollback($conn);
    throw $e;
}
    */

header("Location: ../../../../view/admin/spots.php?status=updated");
exit();
