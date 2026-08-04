<?php

require_once "../../../../view/admin/includes/db.php";
require_once "../../../../model/process/usermodel.php";

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
if (!$id) {
    echo json_encode([]);
    exit();
}

/*
$id = $_GET['id'];
$sql = "SELECT * FROM users WHERE id=?";
$stmt = mysqli_prepare($conn,$sql);
mysqli_stmt_bind_param($stmt,"i",$id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
echo json_encode(mysqli_fetch_assoc($result));
*/

$user = fetchUserById($conn, $id);
echo json_encode($user ?: []);