<?php
// bouncer
require_once 'includes/auth.php';

// Set page title
$pageTitle = "Spots";

require_once 'includes/header.php';
require_once 'includes/sidebar.php';
?>

<?php
$pageTitle = "Spots";
require_once "includes/auth.php";
require_once "includes/header.php";
require_once "includes/db.php";

$query = "SELECT * FROM spots ORDER BY id ASC";
$result = mysqli_query($conn, $query);
?>

<div class="wrapper">
    <?php require_once "includes/sidebar.php"; ?>
    <div class="main">
        <?php require_once "includes/topbar.php"; ?>
        <div class="content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3>Spots Overview</h3>
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addSpotModal">
                    <i class="fa-solid fa-plus"></i> Add Spot
                </button>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <table class="table table-striped table-hover align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Location</th>
                                <th>Noise</th>
                                <th>Privacy</th>
                                <th>Price</th>
                                <th width="140">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($spot = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <td><?= (int) $spot['id']; ?></td>
                                    <td><?= htmlspecialchars($spot['name']); ?></td>
                                    <td><?= htmlspecialchars($spot['location']); ?></td>
                                    <td><?= htmlspecialchars($spot['noise']); ?></td>
                                    <td><?= htmlspecialchars($spot['privacy']); ?></td>
                                    <td><?= htmlspecialchars($spot['price']); ?></td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <button type="button" class="btn btn-warning btn-sm editSpotBtn" data-id="<?= (int) $spot['id']; ?>">
                                                <i class="fa-solid fa-pen"></i>
                                            </button>
                                            <form method="POST" action="actions/spots/delete.php" class="d-inline">
                                                <input type="hidden" name="id" value="<?= (int) $spot['id']; ?>">
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this spot?');">
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

<div class="modal fade" id="addSpotModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="actions/spots/add.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Add Spot</h5>
                    <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3"><label class="form-label">Name</label><input class="form-control" name="name" required></div>
                    <div class="mb-3"><label class="form-label">Location</label><input class="form-control" name="location" required></div>
                    <div class="mb-3"><label class="form-label">Description</label><textarea class="form-control" name="description"></textarea></div>
                    <div class="mb-3"><label class="form-label">Image</label><input class="form-control" name="image"></div>
                    <div class="mb-3"><label class="form-label">Hours</label><input class="form-control" name="hours"></div>
                    <div class="mb-3"><label class="form-label">Noise</label><select class="form-select" name="noise"><option>Low</option><option>Medium</option><option>High</option></select></div>
                    <div class="mb-3"><label class="form-label">Privacy</label><select class="form-select" name="privacy"><option>Low</option><option>Medium</option><option>High</option></select></div>
                    <div class="mb-3"><label class="form-label">Price</label><select class="form-select" name="price"><option>Free</option><option>Low</option><option>Medium</option><option>High</option></select></div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Cancel</button>
                    <button class="btn btn-success" type="submit">Save Spot</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editSpotModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="actions/spots/edit.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Spot</h5>
                    <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit_spot_id">
                    <div class="mb-3"><label class="form-label">Name</label><input class="form-control" name="name" id="edit_spot_name" required></div>
                    <div class="mb-3"><label class="form-label">Location</label><input class="form-control" name="location" id="edit_spot_location" required></div>
                    <div class="mb-3"><label class="form-label">Description</label><textarea class="form-control" name="description" id="edit_spot_description"></textarea></div>
                    <div class="mb-3"><label class="form-label">Image</label><input class="form-control" name="image" id="edit_spot_image"></div>
                    <div class="mb-3"><label class="form-label">Hours</label><input class="form-control" name="hours" id="edit_spot_hours"></div>
                    <div class="mb-3"><label class="form-label">Noise</label><select class="form-select" name="noise" id="edit_spot_noise"><option>Low</option><option>Medium</option><option>High</option></select></div>
                    <div class="mb-3"><label class="form-label">Privacy</label><select class="form-select" name="privacy" id="edit_spot_privacy"><option>Low</option><option>Medium</option><option>High</option></select></div>
                    <div class="mb-3"><label class="form-label">Price</label><select class="form-select" name="price" id="edit_spot_price"><option>Free</option><option>Low</option><option>Medium</option><option>High</option></select></div>
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
