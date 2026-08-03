<?php
require_once "../../../../view/admin/includes/db.php";

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

if (!$id || empty($name) || empty($location)) {
    header("Location: ../../../../view/admin/spots.php");
    exit();
}

$stmt = mysqli_prepare($conn, "UPDATE spots SET name = ?, location = ?, description = ?, image = ?, hours = ?, noise = ?, privacy = ?, price = ? WHERE id = ?");
mysqli_stmt_bind_param($stmt, "ssssssssi", $name, $location, $description, $image, $hours, $noise, $privacy, $price, $id);
mysqli_stmt_execute($stmt);

header("Location: ../../../../view/admin/spots.php");
exit();
