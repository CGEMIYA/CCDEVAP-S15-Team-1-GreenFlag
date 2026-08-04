<?php
require_once "../../../../view/admin/includes/db.php";

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
if (!$id) {
    echo json_encode([]);
    exit();
}

$stmt = mysqli_prepare($conn, "SELECT * FROM spots WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$spot = mysqli_fetch_assoc($result);

if ($spot) {
    $tagStmt = mysqli_prepare($conn, "SELECT t.id, t.tag_name FROM spot_tags st JOIN tags t ON t.id = st.tag_id WHERE st.spot_id = ? ORDER BY t.tag_name ASC");
    mysqli_stmt_bind_param($tagStmt, "i", $id);
    mysqli_stmt_execute($tagStmt);
    $tagResult = mysqli_stmt_get_result($tagStmt);
    $spot["tags"] = [];

    while ($tag = mysqli_fetch_assoc($tagResult)) {
        $spot["tags"][] = $tag;
    }
}

echo json_encode($spot ?: []);
