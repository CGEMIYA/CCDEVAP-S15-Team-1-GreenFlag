<?php

session_start();

require "../../model/config/database.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: login.php");

    exit();

}

$email = trim($_POST["email"] ?? "");
$password = trim($_POST["password"] ?? "");

if (empty($email) || empty($password)) {

    $_SESSION["error"] = "Please enter your admin email and password.";

    header("Location: login.php");

    exit();

}

$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();

if (!$user) {

    $_SESSION["error"] = "Invalid admin credentials.";

    header("Location: login.php");

    exit();

}

if ($user["role"] !== "admin") {

    $_SESSION["error"] = "This account is not authorized for the admin portal.";

    header("Location: login.php");

    exit();

}

if ($user["status"] !== "verified") {

    $_SESSION["error"] = "This admin account is not active.";

    header("Location: login.php");

    exit();

}

$passwordValid = password_verify($password, $user["password"]) || ($user["password"] === $password);

if (!$passwordValid) {

    $_SESSION["error"] = "Invalid admin credentials.";

    header("Location: login.php");

    exit();

}

$_SESSION["user_id"] = $user["id"];
$_SESSION["full_name"] = $user["full_name"];
$_SESSION["email"] = $user["email"];
$_SESSION["role"] = $user["role"];

header("Location: analytics.php");
exit();

?>
