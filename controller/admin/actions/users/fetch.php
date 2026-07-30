<?php

require_once "../../includes/db.php";

$id = $_GET['id'];

$sql = "SELECT * FROM users WHERE id=?";

$stmt = mysqli_prepare($conn,$sql);

mysqli_stmt_bind_param($stmt,"i",$id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

echo json_encode(mysqli_fetch_assoc($result));