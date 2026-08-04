<?php
// model/TagModel.php

// 1. READ ALL
function getAllTags($conn) {
    $query = "SELECT * FROM tags ORDER BY id ASC";
    return mysqli_query($conn, $query);
}

// 2. READ ONE
function fetchTagById($conn, $id) {
    $stmt = mysqli_prepare($conn, "SELECT * FROM tags WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    return mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
}

// 3. Adddddd
function addTag($conn, $tagName) {
    $stmt = mysqli_prepare($conn, "INSERT INTO tags (tag_name) VALUES (?)");
    mysqli_stmt_bind_param($stmt, "s", $tagName);
    return mysqli_stmt_execute($stmt);
}

// 4. edit
function editTag($conn, $id, $tagName) {
    $stmt = mysqli_prepare($conn, "UPDATE tags SET tag_name = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "si", $tagName, $id);
    return mysqli_stmt_execute($stmt);
}

// 5. DELETE
function deleteTag($conn, $id) {
    mysqli_begin_transaction($conn);
    try {
        $spotTagsStmt = mysqli_prepare($conn, "DELETE FROM spot_tags WHERE tag_id = ?");
        mysqli_stmt_bind_param($spotTagsStmt, "i", $id);
        mysqli_stmt_execute($spotTagsStmt);

        $tagStmt = mysqli_prepare($conn, "DELETE FROM tags WHERE id = ?");
        mysqli_stmt_bind_param($tagStmt, "i", $id);
        mysqli_stmt_execute($tagStmt);

        mysqli_commit($conn);
        return true;
    } catch (Exception $e) {
        mysqli_rollback($conn);
        throw $e;
    }
}
?>