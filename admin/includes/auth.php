<?php

if (session_status() === PHP_SESSION_NONE) {

    session_start();

}

if (!isset($_SESSION["user_id"]) || !isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {

    $_SESSION["error"] = "Please sign in as an administrator first.";

    header("Location: login.php");

    exit();

}

?>
