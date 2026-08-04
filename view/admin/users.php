<?php
// view/admin/users.php

require_once 'includes/auth.php';
require_once 'includes/db.php';
require_once '../../model/process/usermodel.php';

$pageTitle = "Users";

require_once 'includes/header.php';
?>

<div class="wrapper">
    <?php require_once "includes/sidebar.php"; ?>
    <div class="main">
        <?php require_once "includes/topbar.php"; ?>
        <div class="content">
            <?php
            require_once "includes/db.php";

            $editingUser = null;
            if (isset($_GET["edit_id"]) && is_numeric($_GET["edit_id"])) {
                $editId = (int) $_GET["edit_id"];
                $editStmt = mysqli_prepare($conn, "SELECT * FROM users WHERE id = ?");
                mysqli_stmt_bind_param($editStmt, "i", $editId);
                mysqli_stmt_execute($editStmt);
                $editResult = mysqli_stmt_get_result($editStmt);
                $editingUser = mysqli_fetch_assoc($editResult);
            }
            ?>

            <?php if ($editingUser): ?>
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="mb-3">Edit User</h5>
                        <form action="../../controller/admin/actions/users/edit.php" method="POST" class="row g-3">
                            <input type="hidden" name="id" value="<?= (int) $editingUser['id']; ?>">
                            <div class="col-md-4">
                                <label class="form-label">Full Name</label>
                                <input type="text" class="form-control" name="full_name" value="<?= htmlspecialchars($editingUser['full_name']); ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($editingUser['email']); ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" placeholder="Leave blank to keep current password">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Role</label>
                                <select class="form-select" name="role">
                                    <option value="student" <?= $editingUser['role'] === 'student' ? 'selected' : ''; ?>>Student</option>
                                    <option value="admin" <?= $editingUser['role'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Status</label>
                                <select class="form-select" name="status">
                                    <option value="pending" <?= $editingUser['status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                    <option value="verified" <?= $editingUser['status'] === 'verified' ? 'selected' : ''; ?>>Verified</option>
                                    <option value="suspended" <?= $editingUser['status'] === 'suspended' ? 'selected' : ''; ?>>Suspended</option>
                                    <option value="banned" <?= $editingUser['status'] === 'banned' ? 'selected' : ''; ?>>Banned</option>
                                </select>
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <button type="submit" class="btn btn-success w-100">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endif; ?>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3>User Management</h3>
                <button
                    class="btn btn-success"
                    data-bs-toggle="modal"
                    data-bs-target="#addUserModal">

                    <i class="fa-solid fa-plus"></i>
                    Add User
                </button>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <table
                        id="usersTable"
                        class="table table-striped table-hover align-middle">

                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Joined</th>
                                <th width="180">Actions</th>
                            </tr>
                        </thead>

                        <tbody>

                        <?php

                        $query = "SELECT * FROM users ORDER BY id ASC";
                        $result = mysqli_query($conn, $query);

                        while($user = mysqli_fetch_assoc($result))
                        {

                        ?>

                        <tr>
                            <td><?= $user['id']; ?></td>
                            <td><?= htmlspecialchars($user['full_name']); ?></td>
                            <td><?= htmlspecialchars($user['email']); ?></td>
                            <td>
                                <?php if($user['role'] == "admin"){ ?>
                                    <span class="badge bg-danger">Admin</span>
                                <?php } else { ?>
                                    <span class="badge bg-primary">Student</span>
                                <?php } ?>
                            </td>

                            <td>

                                <?php

                                switch($user['status']){
                                    case "verified":
                                        echo '<span class="status active">Verified</span>';
                                        break;

                                    case "pending":
                                        echo '<span class="status pending">Pending</span>';
                                        break;

                                    case "suspended":
                                        echo '<span class="status banned">Suspended</span>';
                                        break;

                                    case "banned":
                                        echo '<span class="status banned">Banned</span>';
                                        break;

                                }
                                ?>

                            </td>

                            <td>
                                <?= date("M d, Y", strtotime($user['created_at'])); ?>
                            </td>

                            <td>

                                <div class="table-actions">

                                    <button
                                        type="button"
                                        class="btn btn-warning btn-sm editUserBtn"
                                        data-id="<?= (int) $user['id']; ?>">

                                        <i class="fa-solid fa-pen"></i>

                                    </button>

                                    <form method="POST" action="../../controller/admin/actions/users/delete.php" class="d-inline">
                                        <input type="hidden" name="id" value="<?= $user['id']; ?>">
                                        <button
                                            type="submit"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Delete this user?');">

                                            <i class="fa-solid fa-trash"></i>

                                        </button>
                                    </form>

                                </div>

                            </td>

                        </tr>

                        <?php } ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

<div class="modal fade" id="addUserModal">

<div class="modal-dialog">

<div class="modal-content">

<form action="../../controller/admin/actions/users/add.php" method="POST">

<div class="modal-header">

<h5>Add User</h5>

<button
class="btn-close"
data-bs-dismiss="modal"
type="button">
</button>

</div>

<div class="modal-body">

<div class="mb-3">

<label>Full Name</label>

<input
type="text"
class="form-control"
name="full_name"
required>

</div>

<div class="mb-3">

<label>Email</label>

<input
type="email"
class="form-control"
name="email"
required>

</div>

<div class="mb-3">

<label>Password</label>

<input
type="password"
class="form-control"
name="password"
required>

</div>

<div class="mb-3">

<label>Role</label>

<select
class="form-select"
name="role">

<option value="student">

Student

</option>

<option value="admin">

Admin

</option>

</select>

</div>

<div class="mb-3">

<label>Status</label>

<select
class="form-select"
name="status">

<option value="pending">

Pending

</option>

<option value="verified">

Verified

</option>

<option value="suspended">

Suspended

</option>

<option value="banned">

Banned

</option>

</select>

</div>

</div>

<div class="modal-footer">

<button
class="btn btn-secondary"
data-bs-dismiss="modal"
type="button">

Cancel

</button>

<button
class="btn btn-success"
type="submit">

Save User

</button>

</div>

</form>

</div>

</div>

</div>

<div class="modal fade" id="editUserModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="../../controller/admin/actions/users/edit.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit_id">

                    <div class="mb-3">
                        <label>Full Name</label>
                        <input type="text" class="form-control" name="full_name" id="edit_full_name" required>
                    </div>

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" id="edit_email" required>
                    </div>

                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password" id="edit_password" placeholder="Leave blank to keep current password">
                    </div>

                    <div class="mb-3">
                        <label>Role</label>
                        <select class="form-select" name="role" id="edit_role">
                            <option value="student">Student</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Status</label>
                        <select class="form-select" name="status" id="edit_status">
                            <option value="pending">Pending</option>
                            <option value="verified">Verified</option>
                            <option value="suspended">Suspended</option>
                            <option value="banned">Banned</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Cancel</button>
                    <button class="btn btn-success" type="submit">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="viewUserModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">User Details</h5>
                <button
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <tr>
                        <th>ID</th>
                        <td id="view_id"></td>
                    </tr>

                    <tr>
                        <th>Name</th>
                        <td id="view_name"></td>
                    </tr>

                    <tr>
                        <th>Email</th>
                        <td id="view_email"></td>
                    </tr>

                    <tr>
                        <th>Role</th>
                        <td id="view_role"></td>
                    </tr>

                    <tr>
                        <th>Status</th>
                        <td id="view_status"></td>
                    </tr>

                    <tr>
                        <th>Created</th>
                        <td id="view_created"></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once "includes/footer.php"; ?>