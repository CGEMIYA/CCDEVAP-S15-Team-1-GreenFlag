<?php
$pageTitle = "Users";
require_once "includes/header.php";
?>

<div class="wrapper">
    <?php require_once "includes/sidebar.php"; ?>
    <div class="main">
        <?php require_once "includes/topbar.php"; ?>
        <div class="content">
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

                        require_once "includes/db.php";

                        $query = "SELECT * FROM users ORDER BY id DESC";
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
                                        class="btn btn-info btn-sm viewBtn"
                                        data-id="<?= $user['id']; ?>">

                                        <i class="fa-solid fa-eye"></i>

                                    </button>

                                    <button
                                        class="btn btn-warning btn-sm editBtn"
                                        data-id="<?= $user['id']; ?>">

                                        <i class="fa-solid fa-pen"></i>

                                    </button>

                                    <button
                                        class="btn btn-danger btn-sm deleteBtn"
                                        data-id="<?= $user['id']; ?>">

                                        <i class="fa-solid fa-trash"></i>

                                    </button>

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

<form action="actions/users/add.php" method="POST">

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