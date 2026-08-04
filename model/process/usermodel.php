<?php
// model/process/UserModel.php

// 1. READ ALL USERS
function getAllUsers($conn) {
    return mysqli_query($conn, "SELECT * FROM users ORDER BY id ASC");
}

// 2. READ ONE USER
function fetchUserById($conn, $id) {
    $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

// 3. add USER
function addUser($conn, $full_name, $email, $password, $role = "student", $status = "pending") {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (full_name, email, password, role, status) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssss", $full_name, $email, $hashed_password, $role/*, $status*/);
    return mysqli_stmt_execute($stmt);
}

// 4. Edit USER
function editUser($conn, $id, $full_name, $email, $password, $role, ) {
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = mysqli_prepare($conn, "UPDATE users SET full_name = ?, email = ?, password = ?, role = ?, status = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "sssssi", $full_name, $email, $hashed_password, $role, $id);
    } else {
        $stmt = mysqli_prepare($conn, "UPDATE users SET full_name = ?, email = ?, role = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "ssssi", $full_name, $email, $role, $id);
    }
    return mysqli_stmt_execute($stmt);
}

// 5. DELETE USER 
function deleteUser($conn, $id) {
    mysqli_begin_transaction($conn);
    try {
        $activityStmt = mysqli_prepare($conn, "DELETE FROM activity_logs WHERE user_id = ?");
        mysqli_stmt_bind_param($activityStmt, "i", $id);
        mysqli_stmt_execute($activityStmt);

        $favoritesStmt = mysqli_prepare($conn, "DELETE FROM favorites WHERE user_id = ?");
        mysqli_stmt_bind_param($favoritesStmt, "i", $id);
        mysqli_stmt_execute($favoritesStmt);

        $reviewsStmt = mysqli_prepare($conn, "DELETE FROM reviews WHERE user_id = ?");
        mysqli_stmt_bind_param($reviewsStmt, "i", $id);
        mysqli_stmt_execute($reviewsStmt);

        $announcementsStmt = mysqli_prepare($conn, "DELETE FROM announcements WHERE admin_id = ?");
        mysqli_stmt_bind_param($announcementsStmt, "i", $id);
        mysqli_stmt_execute($announcementsStmt);

        $userStmt = mysqli_prepare($conn, "DELETE FROM users WHERE id = ?");
        mysqli_stmt_bind_param($userStmt, "i", $id);
        mysqli_stmt_execute($userStmt);

        mysqli_commit($conn);
        return true;
    } catch (Exception $e) {
        mysqli_rollback($conn);
        throw $e;
    }
}

// 6. QUICK UPDATE USER STATUS
function updateUserStatus($conn, $id, $status) {
    $stmt = mysqli_prepare($conn, "UPDATE users SET status = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "si", $status, $id);
    return mysqli_stmt_execute($stmt);
}

//bro we keep adding new functions HAHAHAHA
// 7. COUNT TOTAL ADMIN USERS
function getAdminCount($conn) {
    $result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM users WHERE role = 'admin'");
    $row = mysqli_fetch_assoc($result);
    return (int) ($row['total'] ?? 0);
}
?>