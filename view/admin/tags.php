<?php
// bouncer
require_once 'includes/auth.php';
require_once "../../../../model/process/TagModel.php"; // Loads Model
// Set page title
$pageTitle = "Tags";

require_once 'includes/header.php';
require_once 'includes/sidebar.php';
?>

<?php
$pageTitle = "Tags";
require_once "includes/auth.php";
require_once "includes/header.php";
require_once "includes/db.php";

$result=getAllTags($conn);
/*
$query = "SELECT * FROM tags ORDER BY id ASC";
$result = mysqli_query($conn, $query);*/
?>

<div class="wrapper">
    <?php require_once "includes/sidebar.php"; ?>
    <div class="main">
        <?php require_once "includes/topbar.php"; ?>
        <div class="content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3>Tags Overview</h3>
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addTagModal">
                    <i class="fa-solid fa-plus"></i> Add Tag
                </button>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <table class="table table-striped table-hover align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tag Name</th>
                                <th width="140">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($tag = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <td><?= (int) $tag['id']; ?></td>
                                    <td><?= htmlspecialchars($tag['tag_name']); ?></td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <button type="button" class="btn btn-warning btn-sm editTagBtn" data-id="<?= (int) $tag['id']; ?>">
                                                <i class="fa-solid fa-pen"></i>
                                            </button>
                                            <form method="POST" action="../../controller/admin/actions/tags/delete.php" class="d-inline">
                                                <input type="hidden" name="id" value="<?= (int) $tag['id']; ?>">
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this tag?');">
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

<div class="modal fade" id="addTagModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="../../controller/admin/actions/tags/add.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Add Tag</h5>
                    <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3"><label class="form-label">Tag Name</label><input class="form-control" name="tag_name" required></div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Cancel</button>
                    <button class="btn btn-success" type="submit">Save Tag</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editTagModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="../../controller/admin/actions/tags/edit.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Tag</h5>
                    <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit_tag_id">
                    <div class="mb-3"><label class="form-label">Tag Name</label><input class="form-control" name="tag_name" id="edit_tag_name" required></div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Cancel</button>
                    <button class="btn btn-success" type="submit">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once "includes/footer.php"; ?>
