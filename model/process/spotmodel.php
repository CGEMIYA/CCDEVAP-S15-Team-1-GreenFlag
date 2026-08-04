<?php
// model/process/SpotModel.php

// 1. READ ALL SPOTS
function getAllSpots($conn) {
    return mysqli_query($conn, "SELECT * FROM spots ORDER BY id ASC");
}

// 2. READ ALL AVAILABLE TAGS (FOR CHECKBOXES)
function getAvailableTags($conn) {
    $availableTags = [];
    $tagsResult = mysqli_query($conn, "SELECT * FROM tags ORDER BY tag_name ASC");
    while ($tagRow = mysqli_fetch_assoc($tagsResult)) {
        $availableTags[] = $tagRow;
    }
    return $availableTags;
}

// 3. READ SPOT-TAG MAPPINGS (FOR TABLE BADGES)
function getSpotTagMap($conn) {
    $spotTagMap = [];
    $query = "SELECT st.spot_id, t.id, t.tag_name 
              FROM spot_tags st 
              JOIN tags t ON t.id = st.tag_id 
              ORDER BY st.spot_id, t.tag_name ASC";
    $spotTagsResult = mysqli_query($conn, $query);
    while ($spotTagRow = mysqli_fetch_assoc($spotTagsResult)) {
        $spotTagMap[(int) $spotTagRow['spot_id']][] = $spotTagRow;
    }
    return $spotTagMap;
}

// 4. READ ONE SPOT WITH ITS ATTACHED TAGS (FOR EDIT MODAL FETCH)
function fetchSpotById($conn, $id) {
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

    return $spot ?: [];
}

// 5. CREATE SPOT + LINK TAGS
function addSpot($conn, $name, $location, $description, $image, $hours, $noise, $privacy, $price, $rawTagIds) {
    mysqli_begin_transaction($conn);
    try {
        $stmt = mysqli_prepare($conn, "INSERT INTO spots (name, location, description, image, hours, noise, privacy, price) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssssssss", $name, $location, $description, $image, $hours, $noise, $privacy, $price);
        mysqli_stmt_execute($stmt);

        $spotId = mysqli_insert_id($conn);
        $tagIds = [];

        if (is_array($rawTagIds)) {
            foreach ($rawTagIds as $tagId) {
                $validId = filter_var($tagId, FILTER_VALIDATE_INT);
                if ($validId) {
                    $tagIds[] = $validId;
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
        return true;
    } catch (Exception $e) {
        mysqli_rollback($conn);
        throw $e;
    }
}

// 6. UPDATE SPOT + SYNC TAGS
function editSpot($conn, $id, $name, $location, $description, $image, $hours, $noise, $privacy, $price, $rawTagIds) {
    mysqli_begin_transaction($conn);
    try {
        $stmt = mysqli_prepare($conn, "UPDATE spots SET name = ?, location = ?, description = ?, image = ?, hours = ?, noise = ?, privacy = ?, price = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "ssssssssi", $name, $location, $description, $image, $hours, $noise, $privacy, $price, $id);
        mysqli_stmt_execute($stmt);

        $clearTagsStmt = mysqli_prepare($conn, "DELETE FROM spot_tags WHERE spot_id = ?");
        mysqli_stmt_bind_param($clearTagsStmt, "i", $id);
        mysqli_stmt_execute($clearTagsStmt);

        $tagIds = [];
        if (is_array($rawTagIds)) {
            foreach ($rawTagIds as $tagId) {
                $validId = filter_var($tagId, FILTER_VALIDATE_INT);
                if ($validId) {
                    $tagIds[] = $validId;
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
        return true;
    } catch (Exception $e) {
        mysqli_rollback($conn);
        throw $e;
    }
}

// 7. DELETE SPOT
function deleteSpot($conn, $id) {
    mysqli_begin_transaction($conn);
    try {
        $spotTagsStmt = mysqli_prepare($conn, "DELETE FROM spot_tags WHERE spot_id = ?");
        mysqli_stmt_bind_param($spotTagsStmt, "i", $id);
        mysqli_stmt_execute($spotTagsStmt);

        $reviewsStmt = mysqli_prepare($conn, "DELETE FROM reviews WHERE spot_id = ?");
        mysqli_stmt_bind_param($reviewsStmt, "i", $id);
        mysqli_stmt_execute($reviewsStmt);

        $spotStmt = mysqli_prepare($conn, "DELETE FROM spots WHERE id = ?");
        mysqli_stmt_bind_param($spotStmt, "i", $id);
        mysqli_stmt_execute($spotStmt);

        mysqli_commit($conn);
        return true;
    } catch (Exception $e) {
        mysqli_rollback($conn);
        throw $e;
    }
}
?>