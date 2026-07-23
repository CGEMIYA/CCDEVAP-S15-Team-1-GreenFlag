<?php
require_once "../../includes/db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../../spots.php");
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

if (empty($name) || empty($location)) {
    header("Location: ../../spots.php");
    exit();
}

$stmt = mysqli_prepare($conn, "INSERT INTO spots (name, location, description, image, hours, noise, privacy, price) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt, "ssssssss", $name, $location, $description, $image, $hours, $noise, $privacy, $price);
mysqli_stmt_execute($stmt);

header("Location: ../../spots.php");
exit();
